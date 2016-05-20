<?php
/**
 *
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\Spotify\ValueObject;

class ArtistSimplified
{
    /** @var string */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $spotifyHref;
    /** @var string */
    private $spotifyUri;

    /**
     * @return string|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return ArtistSimplified
     */
    public function setId(string $id) : ArtistSimplified
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return ArtistSimplified
     */
    public function setName(string $name) : ArtistSimplified
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSpotifyHref()
    {
        return $this->spotifyHref;
    }

    /**
     * @param string $spotifyHref
     *
     * @return ArtistSimplified
     */
    public function setSpotifyHref(string $spotifyHref) : ArtistSimplified
    {
        $this->spotifyHref = $spotifyHref;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSpotifyUri()
    {
        return $this->spotifyUri;
    }

    /**
     * @param string $spotifyUri
     *
     * @return ArtistSimplified
     */
    public function setSpotifyUri(string $spotifyUri) : ArtistSimplified
    {
        $this->spotifyUri = $spotifyUri;

        return $this;
    }
}
