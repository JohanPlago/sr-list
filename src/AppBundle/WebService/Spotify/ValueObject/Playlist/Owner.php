<?php
/**
 * A playlist owner
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\Spotify\ValueObject\Playlist;

class Owner
{
    /** @var array */
    protected $externalUrls = [];
    /** @var string */
    protected $href;
    /** @var string */
    protected $id;
    /** @var string */
    protected $type = 'user';
    /** @var string */
    protected $uri;

    /**
     * @return array
     */
    public function getExternalUrls()
    {
        return $this->externalUrls;
    }

    /**
     * @param array $externalUrls
     *
     * @return Owner
     */
    public function setExternalUrls($externalUrls)
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
     * @return Owner
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
     * @return Owner
     */
    public function setId($id)
    {
        $this->id = $id;

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
     * @return Owner
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
     * @return Owner
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }
}
