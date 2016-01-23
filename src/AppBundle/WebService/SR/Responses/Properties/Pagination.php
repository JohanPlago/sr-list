<?php
/**
 * The pagination object
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\SR\Responses\Properties;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class Pagination
{
    /**
     * Current page
     *
     * @var integer
     *
     * @Type("integer")
     */
    private $page;

    /**
     * Number of items per page
     *
     * @var integer
     *
     * @Type("integer")
     */
    private $size;

    /**
     * Total number of items found
     *
     * @var integer
     *
     * @Type("integer")
     * @SerializedName("totalhits")
     */
    private $totalHits;

    /**
     * @var integer
     *
     * @Type("integer")
     * @SerializedName("totalpages")
     */
    private $totalPages;

    /**
     * The url to the next page to index
     *
     * @var string
     *
     * @Type("string")
     * @SerializedName("nextpage")
     */
    private $nextPage;

    /**
     * @return int
     */
    public function getPage() : int
    {
        return $this->page;
    }

    /**
     * @param int $page
     *
     * @return Pagination
     */
    public function setPage(int $page) : Pagination
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return int
     */
    public function getSize() : int
    {
        return $this->size;
    }

    /**
     * @param int $size
     *
     * @return Pagination
     */
    public function setSize(int $size) : Pagination
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalHits() : int
    {
        return $this->totalHits;
    }

    /**
     * @param int $totalHits
     *
     * @return Pagination
     */
    public function setTotalHits(int $totalHits) : Pagination
    {
        $this->totalHits = $totalHits;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalPages() : int
    {
        return $this->totalPages;
    }

    /**
     * @param int $totalPages
     *
     * @return Pagination
     */
    public function setTotalPages(int $totalPages) : Pagination
    {
        $this->totalPages = $totalPages;

        return $this;
    }

    /**
     * @return string
     */
    public function getNextPage() : string
    {
        return $this->nextPage;
    }

    /**
     * @param string $nextPage
     *
     * @return Pagination
     */
    public function setNextPage(string $nextPage) : Pagination
    {
        $this->nextPage = $nextPage;

        return $this;
    }
}
