<?php

namespace AppBundle\WebService\SR\Responses;

use AppBundle\WebService\SR\Responses\Entities\Episode;
use JMS\Serializer\Annotation as Jms;

/**
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */
class AllEpisodesResponse extends PaginatedBaseResponse
{
    /**
     * @var Episode[]
     *
     * @Jms\Type("array<AppBundle\WebService\SR\Responses\Entities\Episode>")
     */
    private $episodes;

    /**
     * Returns all episodes
     *
     * @return Episode[]
     */
    public function getEntities() : array
    {
        return $this->getEpisodes();
    }

    /**
     * @return Episode[]
     */
    public function getEpisodes() : array
    {
        return $this->episodes;
    }

    /**
     * @param Episode[] $episodes
     *
     * @return AllEpisodesResponse
     */
    public function setEpisodes(array $episodes) : AllEpisodesResponse
    {
        $this->episodes = $episodes;

        return $this;
    }
}
