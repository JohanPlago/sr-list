<?php
/**
 * Reference that lists tracks of a playlist
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\Spotify\ValueObject\Playlist;

class TracksReference
{
    /** @var string */
    protected $href;
    /** @var int */
    protected $total;

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param int $total
     *
     * @return TracksReference
     */
    public function setTotal($total)
    {
        $this->total = $total;

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
     * @return TracksReference
     */
    public function setHref($href)
    {
        $this->href = $href;

        return $this;
    }
}
