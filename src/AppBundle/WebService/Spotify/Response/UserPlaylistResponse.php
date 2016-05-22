<?php
/**
 * The response when calling the user playlists
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\Spotify\Response;

use AppBundle\WebService\Spotify\ValueObject\Playlist;

class UserPlaylistResponse
{
    /** @var string */
    protected $href;
    /** @var Playlist[] */
    protected $items = [];
    /** @var int */
    protected $limit;
    /** @var string|null */
    protected $next;
    /** @var int */
    protected $offset;
    /** @var string|null */
    protected $previous;
    /** @var int */
    protected $total;

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
     * @return UserPlaylistResponse
     */
    public function setHref(string $href)
    {
        $this->href = $href;

        return $this;
    }

    /**
     * @return Playlist[]
     */
    public function getItems() : array
    {
        return $this->items;
    }

    /**
     * @param Playlist[] $items
     *
     * @return UserPlaylistResponse
     */
    public function setItems(array $items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     *
     * @return UserPlaylistResponse
     */
    public function setLimit(int $limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * @param null|string $next
     *
     * @return UserPlaylistResponse
     */
    public function setNext(string $next)
    {
        $this->next = $next;

        return $this;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     *
     * @return UserPlaylistResponse
     */
    public function setOffset(int $offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPrevious()
    {
        return $this->previous;
    }

    /**
     * @param null|string $previous
     *
     * @return UserPlaylistResponse
     */
    public function setPrevious(string $previous)
    {
        $this->previous = $previous;

        return $this;
    }

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
     * @return UserPlaylistResponse
     */
    public function setTotal(int $total)
    {
        $this->total = $total;

        return $this;
    }
}
