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
use Doctrine\ORM\EntityManager;
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
    /** @var SpotifyWebAPI */
    protected $spotifyWebApi;

    /**
     * SpotifyOAuthUserProvider constructor.
     *
     * @param SpotifyUserRepository $userRepository
     * @param EntityManager $em
     */
    public function __construct(SpotifyUserRepository $userRepository, EntityManager $em, $spotifyWebApi)
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
        $this->spotifyWebApi = $spotifyWebApi;
    }

    public function loadUserByUsername($username)
    {
        $user = $this->userRepository->findOneBy(['spotifyId' => $username]);

        if (!$user instanceof SpotifyUser) {
            return new SpotifyUser($username);
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
