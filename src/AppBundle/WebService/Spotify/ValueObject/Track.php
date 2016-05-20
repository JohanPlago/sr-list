<?php
/**
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\Spotify\ValueObject;

class Track
{
    /** @var string */
    private $id;
    /** @var string */
    private $name;
    /** @var ArtistSimplified[] */
    private $artists = [];
    /** @var string */
    private $spotifyUri;
    /** @var string */
    private $spotifyHref;
    /** @var AlbumSimplified */
    private $album;

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
     * @return Track
     */
    public function setId(string $id) : Track
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
     * @return Track
     */
    public function setName(string $name) : Track
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return ArtistSimplified[]
     */
    public function getArtists() : array
    {
        return $this->artists;
    }

    /**
     * @param ArtistSimplified[] $artists
     *
     * @return Track
     */
    public function setArtists(array $artists) : Track
    {
        $this->artists = $artists;

        return $this;
    }

    /**
     * @return string | null
     */
    public function getSpotifyUri()
    {
        return $this->spotifyUri;
    }

    /**
     * @param string $spotifyUri
     *
     * @return Track
     */
    public function setSpotifyUri(string $spotifyUri) : Track
    {
        $this->spotifyUri = $spotifyUri;

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
     * @return Track
     */
    public function setSpotifyHref(string $spotifyHref) : Track
    {
        $this->spotifyHref = $spotifyHref;

        return $this;
    }

    /**
     * @return AlbumSimplified
     */
    public function getAlbum() : AlbumSimplified
    {
        if (is_null($this->album)) {
            $this->album = new AlbumSimplified();
        }

        return $this->album;
    }

    /**
     * @param AlbumSimplified $album
     *
     * @return Track
     */
    public function setAlbum(AlbumSimplified $album) : Track
    {
        $this->album = $album;

        return $this;
    }
}
