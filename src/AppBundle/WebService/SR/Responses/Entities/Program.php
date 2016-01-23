<?php
/**
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\SR\Responses\Entities;

use AppBundle\WebService\SR\Responses\Properties\Channel;
use AppBundle\WebService\SR\Responses\Properties\ProgramCategory;
use AppBundle\WebService\SR\Responses\Properties\SocialMediaPlatform;
use JMS\Serializer\Annotation as Jms;

class Program
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
     * @var string
     *
     * @Jms\Type("string")
     */
    private $description;

    /**
     * @var ProgramCategory
     *
     * @Jms\Type("AppBundle\WebService\SR\Responses\Properties\ProgramCategory")
     * @Jms\SerializedName("programcategory")
     */
    private $programCategory;

    /**
     * @var string
     *
     * @Jms\Type("string")
     * @Jms\SerializedName("programurl")
     */
    private $programUrl;

    /**
     * @var string
     *
     * @Jms\Type("string")
     * @Jms\SerializedName("programimage")
     */
    private $programImage;

    /**
     * @var string
     *
     * @Jms\Type("string")
     * @Jms\SerializedName("socialimage")
     */
    private $socialImage;

    /**
     * @var SocialMediaPlatform[]
     *
     * @Jms\Type("array<AppBundle\WebService\SR\Responses\Properties\SocialMediaPlatform>")
     * @Jms\SerializedName("socialmediaplatforms")
     */
    private $socialMediaPlatforms;

    /**
     * @var Channel
     *
     * @Jms\Type("AppBundle\WebService\SR\Responses\Properties\Channel")
     */
    private $channel;

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
     * @return Program
     */
    public function setSrId(int $srId) : Program
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
     * @return Program
     */
    public function setName(string $name) : Program
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Program
     */
    public function setDescription(string $description) : Program
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return ProgramCategory
     */
    public function getProgramCategory() : ProgramCategory
    {
        return $this->programCategory;
    }

    /**
     * @param ProgramCategory $programCategory
     *
     * @return Program
     */
    public function setProgramCategory(ProgramCategory $programCategory) : Program
    {
        $this->programCategory = $programCategory;

        return $this;
    }

    /**
     * @return string
     */
    public function getProgramUrl() : string
    {
        return $this->programUrl;
    }

    /**
     * @param string $programUrl
     *
     * @return Program
     */
    public function setProgramUrl(string $programUrl) : Program
    {
        $this->programUrl = $programUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getProgramImage() : string
    {
        return $this->programImage;
    }

    /**
     * @param string $programImage
     *
     * @return Program
     */
    public function setProgramImage(string $programImage) : Program
    {
        $this->programImage = $programImage;

        return $this;
    }

    /**
     * @return string
     */
    public function getSocialImage() : string
    {
        return $this->socialImage;
    }

    /**
     * @param string $socialImage
     *
     * @return Program
     */
    public function setSocialImage(string $socialImage) : Program
    {
        $this->socialImage = $socialImage;

        return $this;
    }

    /**
     * @return \AppBundle\WebService\SR\Responses\Properties\SocialMediaPlatform[]
     */
    public function getSocialMediaPlatforms() : array
    {
        return $this->socialMediaPlatforms;
    }

    /**
     * @param \AppBundle\WebService\SR\Responses\Properties\SocialMediaPlatform[] $socialMediaPlatforms
     *
     * @return Program
     */
    public function setSocialMediaPlatforms(array $socialMediaPlatforms) : Program
    {
        $this->socialMediaPlatforms = $socialMediaPlatforms;

        return $this;
    }

    /**
     * @return Channel
     */
    public function getChannel() : Channel
    {
        return $this->channel;
    }

    /**
     * @param Channel $channel
     *
     * @return Program
     */
    public function setChannel(Channel $channel) : Program
    {
        $this->channel = $channel;

        return $this;
    }
}
