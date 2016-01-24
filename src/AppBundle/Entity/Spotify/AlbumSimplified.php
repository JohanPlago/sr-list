<?php
/**
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\Entity\Spotify;

class AlbumSimplified
{
    /** @var string */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $spotifyHref;
    /** @var string */
    private $spotifyUri;
    /** @var Image[] */
    private $images = [];

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
     * @return AlbumSimplified
     */
    public function setId(string $id) : AlbumSimplified
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
     * @return AlbumSimplified
     */
    public function setName(string $name) : AlbumSimplified
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
     * @return AlbumSimplified
     */
    public function setSpotifyHref(string $spotifyHref) : AlbumSimplified
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
     * @return AlbumSimplified
     */
    public function setSpotifyUri(string $spotifyUri) : AlbumSimplified
    {
        $this->spotifyUri = $spotifyUri;

        return $this;
    }

    /**
     * @return Image[]
     */
    public function getImages() : array
    {
        return $this->images;
    }

    /**
     * @param Image[] $images
     *
     * @return AlbumSimplified
     */
    public function setImages(array $images) : AlbumSimplified
    {
        $this->images = $images;

        return $this;
    }
}
