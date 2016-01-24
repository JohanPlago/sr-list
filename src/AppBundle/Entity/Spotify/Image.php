<?php
/**
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\Entity\Spotify;

class Image
{
    /** @var integer */
    private $width;
    /** @var integer */
    private $url;
    /** @var integer */
    private $height;

    /**
     * @return mixed
     */
    public function getWidth() : int
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     *
     * @return Image
     */
    public function setWidth(int $width) : Image
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl() : string
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     *
     * @return Image
     */
    public function setUrl(string $url) : Image
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeight() : int
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     *
     * @return Image
     */
    public function setHeight(int $height) : Image
    {
        $this->height = $height;

        return $this;
    }
}
