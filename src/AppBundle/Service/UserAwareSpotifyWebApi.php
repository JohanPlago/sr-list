<?php
/**
 *
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\Service;

use AppBundle\Entity\SpotifyUser;
use SpotifyWebAPI\SpotifyWebAPI;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserAwareSpotifyWebApi extends SpotifyWebAPI
{
    /** @var TokenStorage */
    protected $tokenStorage;

    /**
     * Set the token storage
     *
     * @param TokenStorage $tokenStorage
     *
     * @return $this
     */
    public function setTokenStorage(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function authHeaders()
    {
        $token = $this->tokenStorage->getToken();

        // Save the access token if user is logged in
        if ($token instanceof TokenInterface && $token->getUser() instanceof SpotifyUser) {
            $this->setAccessToken($this->tokenStorage->getToken()->getUser()->getAccessToken());
        }

        return parent::authHeaders();
    }


}
