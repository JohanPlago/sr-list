<?php
/**
 * Serializable response object
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\SR\Responses;

use AppBundle\WebService\SR\Responses\Properties\Pagination;
use JMS\Serializer\Annotation\Type;

abstract class PaginatedBaseResponse
{
    /**
     * @var string
     *
     * @Type("string")
     */
    private $copyright;

    /**
     * @var Pagination
     *
     * @Type("AppBundle\WebService\SR\Responses\Properties\Pagination")
     */
    private $pagination;

    /**
     * Get all found entities
     *
     * @return array
     */
    public abstract function getEntities() : array;

    /**
     * @return string
     */
    public function getCopyright() : string
    {
        return $this->copyright;
    }

    /**
     * @param string $copyright
     *
     * @return PaginatedBaseResponse
     */
    public function setCopyright(string $copyright) : PaginatedBaseResponse
    {
        $this->copyright = $copyright;

        return $this;
    }

    /**
     * @return Pagination
     */
    public function getPagination() : Pagination
    {
        return $this->pagination;
    }

    /**
     * @param Pagination $pagination
     *
     * @return PaginatedBaseResponse
     */
    public function setPagination(Pagination $pagination) : PaginatedBaseResponse
    {
        $this->pagination = $pagination;

        return $this;
    }
}
