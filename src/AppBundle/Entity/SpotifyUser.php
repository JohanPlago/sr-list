<?php
/**
 * A Spotify user
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUser;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\SpotifyUserRepository")
 * @ORM\Table(name="spotify_user")
 */
class SpotifyUser extends OAuthUser implements EquatableInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue()
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=64)
     */
    protected $spotifyId;
    /**
     * @ORM\Column(type="string", length=64)
     */
    protected $displayName = '';
    /**
     * @ORM\Column(type="string", length=512)
     */
    protected $imageUrl = '';
    /**
     * @ORM\Column(type="string", length=256)
     */
    protected $profileUrl = '';
    /**
     * @ORM\Column(type="string", length=512)
     */
    protected $accessToken;
    /**
     * @ORM\Column(type="integer")
     */
    protected $accessTokenExpires;
    /**
     * @ORM\Column(type="string", length=256)
     */
    protected $refreshToken;

    /**
     * @return mixed
     */
    public function getDisplayName() : string
    {
        return $this->displayName;
    }

    /**
     * @param mixed $displayName
     *
     * @return SpotifyUser
     */
    public function setDisplayName(string $displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImageUrl() : string
    {
        return $this->imageUrl;
    }

    /**
     * @param mixed $imageUrl
     *
     * @return SpotifyUser
     */
    public function setImageUrl(string $imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProfileUrl() : string
    {
        return $this->profileUrl;
    }

    /**
     * @param mixed $profileUrl
     *
     * @return SpotifyUser
     */
    public function setProfileUrl(string $profileUrl)
    {
        $this->profileUrl = $profileUrl;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccessToken() : string
    {
        return $this->accessToken;
    }

    /**
     * @param mixed $accessToken
     *
     * @return SpotifyUser
     */
    public function setAccessToken(string $accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccessTokenExpires() : int
    {
        return $this->accessTokenExpires;
    }

    /**
     * @param mixed $accessTokenExpires
     *
     * @return SpotifyUser
     */
    public function setAccessTokenExpires(int $accessTokenExpires)
    {
        $this->accessTokenExpires = $accessTokenExpires;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRefreshToken() : string
    {
        return $this->refreshToken;
    }

    /**
     * @param mixed $refreshToken
     *
     * @return SpotifyUser
     */
    public function setRefreshToken(string $refreshToken)
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return SpotifyUser
     */
    public function setId(string $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpotifyId() : string
    {
        return $this->spotifyId;
    }

    /**
     * @param mixed $spotifyId
     *
     * @return SpotifyUser
     */
    public function setSpotifyId(string $spotifyId)
    {
        $this->spotifyId = $spotifyId;

        return $this;
    }

    public function serialize()
    {
        return serialize(
            [
                'id'        => $this->getId(),
                'spotifyId' => $this->getSpotifyId(),
            ]
        );
    }


    public function unserialize($serialized)
    {
        $unserialized = unserialize($serialized);
        $this->id = $unserialized['id'];
        $this->spotifyId = $unserialized['spotifyId'];
    }

    public function isEqualTo(UserInterface $user)
    {
        return $this->spotifyId === $user->getUsername();
    }

    /**
     * Gives the user id (which in spotify's case is the username)
     *
     * @return string
     */
    public function getUsername() : string
    {
        return $this->getSpotifyId();
    }
}
