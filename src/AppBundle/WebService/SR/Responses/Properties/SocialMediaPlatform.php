<?php
/**
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\SR\Responses\Properties;

use JMS\Serializer\Annotation as Jms;

class SocialMediaPlatform
{
    /**
     * @var string
     *
     * @Jms\Type("string")
     */
    private $platform;

    /**
     * @var string
     *
     * @Jms\Type("string")
     * @Jms\SerializedName("platformurl")
     */
    private $platformUrl;

    /**
     * @return string
     */
    public function getPlatform() : string
    {
        return $this->platform;
    }

    /**
     * @param string $platform
     *
     * @return SocialMediaPlatform
     */
    public function setPlatform(string $platform) : SocialMediaPlatform
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlatformUrl() : string
    {
        return $this->platformUrl;
    }

    /**
     * @param string $platformUrl
     *
     * @return SocialMediaPlatform
     */
    public function setPlatformUrl(string $platformUrl) : SocialMediaPlatform
    {
        $this->platformUrl = $platformUrl;

        return $this;
    }
}
