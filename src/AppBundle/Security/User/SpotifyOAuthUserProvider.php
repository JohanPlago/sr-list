<?php
/**
 * Provides users signed in with spotify oauth
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\Security\User;

use AppBundle\Entity\Repository\SpotifyUserRepository;
use AppBundle\Entity\SpotifyUser;
use AppBundle\Service\UserAwareSpotifyWebApi;
use Doctrine\ORM\EntityManager;
use HWI\Bundle\OAuthBundle\OAuth\ResourceOwner\SpotifyResourceOwner;
use HWI\Bundle\OAuthBundle\OAuth\ResourceOwnerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use SpotifyWebAPI\SpotifyWebAPI;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Session\Session;

class SpotifyOAuthUserProvider extends OAuthUserProvider
{
    /** @var SpotifyUserRepository */
    protected $userRepository;
    /** @var EntityManager */
    protected $em;
    /** @var UserAwareSpotifyWebApi */
    protected $spotifyWebApi;
    /** @var ResourceOwnerInterface */
    protected $resourceOwner;

    /**
     * SpotifyOAuthUserProvider constructor.
     *
     * @param SpotifyUserRepository $userRepository
     * @param EntityManager $em
     * @param UserAwareSpotifyWebApi $spotifyWebApi
     * @param ResourceOwnerInterface $resourceOwner
     */
    public function __construct(
        SpotifyUserRepository $userRepository,
        EntityManager $em,
        UserAwareSpotifyWebApi $spotifyWebApi,
        SpotifyResourceOwner $resourceOwner
    ) {
        $this->userRepository = $userRepository;
        $this->em = $em;
        $this->spotifyWebApi = $spotifyWebApi;
        $this->resourceOwner = $resourceOwner;
    }

    public function loadUserByUsername($username)
    {
        $user = $this->userRepository->findOneBy(['spotifyId' => $username]);

        if (!$user instanceof SpotifyUser) {
            return new SpotifyUser($username);
        }

        if ($user->getAccessTokenExpires() <= (time() + 10)) {
            $refreshResponse = $this->resourceOwner->refreshAccessToken($user->getRefreshToken());
            $user->setAccessToken($refreshResponse['access_token']);
            $user->setAccessTokenExpires(time() + $refreshResponse['expires_in']);
            $this->em->persist($user);
            $this->em->flush();
        }

        return $user;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $user = $this->userRepository->findOneBy(['spotifyId' => $response->getUsername()]);

        if (!$user instanceof SpotifyUser) {
            $user = new SpotifyUser($response->getUsername());
        }

        $user
            ->setSpotifyId($response->getUsername())
            ->setDisplayName($response->getRealName())
            ->setAccessToken($response->getAccessToken())
            ->setAccessTokenExpires(time()+$response->getExpiresIn())
            ->setRefreshToken($response->getRefreshToken())
            ->setProfileUrl($response->getResponse()['href']);

        $responseHasImages = isset($response->getResponse()['images']) && is_array($response->getResponse()['images']);
        $responseImageExists = array_key_exists('url',$response->getResponse()['images'][0]);

        if ($responseHasImages && $responseImageExists) {
            $user->setImageUrl($response->getResponse()['images'][0]['url']);
        }

        $this->em->persist($user);
        $this->em->flush();

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === SpotifyUser::class;
    }
}
