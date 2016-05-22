<?php
/**
 * A playlist
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\Spotify\ValueObject;

use AppBundle\WebService\Spotify\ValueObject\Playlist\{
    Owner,
    TracksReference
};

class Playlist
{
    /** @var bool */
    protected $collaborative;
    /** @var array */
    protected $externalUrls = [];
    /** @var string */
    protected $href;
    /** @var string */
    protected $id;
    /** @var Image[] */
    protected $images = [];
    /** @var string */
    protected $name;
    /** @var Owner */
    protected $owner;
    /** @var bool */
    protected $public;
    /** @var string */
    protected $snapshotId;
    /** @var TracksReference */
    protected $tracks;
    /** @var string */
    protected $type = 'playlist';
    /** @var string */
    protected $uri;

    /**
     * @return boolean
     */
    public function isCollaborative()
    {
        return $this->collaborative;
    }

    /**
     * @param boolean $collaborative
     *
     * @return Playlist
     */
    public function setCollaborative(bool $collaborative)
    {
        $this->collaborative = $collaborative;

        return $this;
    }

    /**
     * @return array
     */
    public function getExternalUrls() : array
    {
        return $this->externalUrls;
    }

    /**
     * @param array $externalUrls
     *
     * @return Playlist
     */
    public function setExternalUrls(array $externalUrls)
    {
        $this->externalUrls = $externalUrls;

        return $this;
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param string $href
     *
     * @return Playlist
     */
    public function setHref($href)
    {
        $this->href = $href;

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Playlist
     */
    public function setId($id)
    {
        $this->id = $id;

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
     * @return Playlist
     */
    public function setImages(array $images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Playlist
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Playlist\Owner
     */
    public function getOwner() : Owner
    {
        return $this->owner;
    }

    /**
     * @param Playlist\Owner $owner
     *
     * @return Playlist
     */
    public function setOwner(Owner $owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isPublic()
    {
        return $this->public;
    }

    /**
     * @param boolean $public
     *
     * @return Playlist
     */
    public function setPublic(bool $public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * @return string
     */
    public function getSnapshotId()
    {
        return $this->snapshotId;
    }

    /**
     * @param string $snapshotId
     *
     * @return Playlist
     */
    public function setSnapshotId($snapshotId)
    {
        $this->snapshotId = $snapshotId;

        return $this;
    }

    /**
     * @return TracksReference
     */
    public function getTracks() : TracksReference
    {
        return $this->tracks;
    }

    /**
     * @param TracksReference $tracks
     *
     * @return Playlist
     */
    public function setTracks(TracksReference $tracks)
    {
        $this->tracks = $tracks;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Playlist
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     *
     * @return Playlist
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }
}
