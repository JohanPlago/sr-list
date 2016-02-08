<?php
/**
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\SR\Responses;

use AppBundle\WebService\SR\Responses\Entity\Episode;
use JMS\Serializer\Annotation as Jms;

/**
 * Class EpisodeResponse
 *
 * Response object when fetching a single episode
 */
class EpisodeResponse
{
    /**
     * @var Episode
     *
     * @Jms\Type("AppBundle\WebService\SR\Responses\Entity\Episode")
     */
    private $episode;

    /**
     * Return a response
     *
     * @return Episode[]
     */
    public function getEntities() : array
    {
        return [$this->getEpisode()];
    }

    /**
     * @return Episode
     */
    public function getEpisode() : Episode
    {
        return $this->episode;
    }

    /**
     * @param Episode $episode
     *
     * @return EpisodeResponse
     */
    public function setEpisode(Episode $episode) : EpisodeResponse
    {
        $this->episode = $episode;

        return $this;
    }
}
