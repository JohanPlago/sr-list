<?php
/**
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\SR\Responses\Properties;

use JMS\Serializer\Annotation as Jms;

class Channel
{
    /**
     * @var int
     *
     * @Jms\Type("integer")
     * @Jms\SerializedName("id")
     */
    private $srId;

    /**
     * @var string
     *
     * @Jms\Type("string")
     */
    private $name;

    /**
     * @return int
     */
    public function getSrId() : int
    {
        return $this->srId;
    }

    /**
     * @param int $srId
     *
     * @return Channel
     */
    public function setSrId(int $srId) : Channel
    {
        $this->srId = $srId;

        return $this;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Channel
     */
    public function setName(string $name) : Channel
    {
        $this->name = $name;

        return $this;
    }
}
