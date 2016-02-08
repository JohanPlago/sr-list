<?php
/**
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\SR\Responses;

use AppBundle\WebService\SR\Responses\Entity\Song;
use JMS\Serializer\Annotation as Jms;

class PlaylistResponse
{
    /**
     * @var Song[]
     *
     * @Jms\Type("array<AppBundle\WebService\SR\Responses\Entity\Song>")
     * @Jms\SerializedName("song")
     */
    private $songs;

    /**
     * @return Song[]
     */
    public function getSongs() : array
    {
        return $this->songs;
    }

    /**
     * @param Song $songs
     *
     * @return PlaylistResponse
     */
    public function setSongs(array $songs) : PlaylistResponse
    {
        $this->songs = $songs;

        return $this;
    }
}
