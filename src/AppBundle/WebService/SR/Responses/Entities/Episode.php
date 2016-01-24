<?php

namespace AppBundle\WebService\SR\Responses\Entities;

use AppBundle\WebService\SR\Responses\Properties\DownloadPodFile;
use JMS\Serializer\Annotation as Jms;

/**
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */
class Episode
{
    /**
     * @var integer
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
    private $title;

    /**
     * @var string
     *
     * @Jms\Type("string")
     */
    private $description;

    /**
     * @var string
     *
     * @Jms\Type("string")
     * @Jms\SerializedName("url")
     */
    private $webUrl;

    /**
     * @var Program
     *
     * @Jms\Type("AppBundle\WebService\SR\Responses\Entities\Program")
     */
    private $program;

    /**
     * @var \DateTime
     *
     * @Jms\Type("DateTime<'\/\D\a\t\e\(U\)\/'>")
     * @Jms\SerializedName("publishdateutc")
     */
    private $publishDateUtc;

    /**
     * @var string
     *
     * @Jms\Type("string")
     * @Jms\SerializedName("imageurltemplate")
     */
    private $imageUrl;

    /**
     * @var DownloadPodFile
     *
     * @Jms\Type("AppBundle\WebService\SR\Responses\Properties\DownloadPodFile")
     * @Jms\SerializedName("downloadpodfile")
     */
    private $downloadPodFile;

    /**
     * The date is sent in milliseconds so we need to fix that...
     *
     * @Jms\PostDeserialize
     */
    public function dateTimeFromMilliseconds()
    {
        if ($this->publishDateUtc instanceof \DateTime) {
            $originalTimestamp = (int)$this->publishDateUtc->format('U');
            $this->publishDateUtc = \DateTime::createFromFormat('U', $originalTimestamp / 1000);
        }
    }

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
     * @return Episode
     */
    public function setSrId(int $srId) : Episode
    {
        $this->srId = $srId;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Episode
     */
    public function setTitle(string $title) : Episode
    {
        $this->title = $title;

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
     * @return Episode
     */
    public function setDescription(string $description) : Episode
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getWebUrl() : string
    {
        return $this->webUrl;
    }

    /**
     * @param string $webUrl
     *
     * @return Episode
     */
    public function setWebUrl(string $webUrl) : Episode
    {
        $this->webUrl = $webUrl;

        return $this;
    }

    /**
     * @return Program
     */
    public function getProgram() : Program
    {
        // Add empty pod file if it's not set (might not happen during deserialization)
        if (is_null($this->program)) {
            $this->program = new Program();
        }

        return $this->program;
    }

    /**
     * @param Program $program
     *
     * @return Episode
     */
    public function setProgram(Program $program) : Episode
    {
        $this->program = $program;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPublishDateUtc() : \DateTime
    {
        return $this->publishDateUtc;
    }

    /**
     * @param \DateTime $publishDateUtc
     *
     * @return Episode
     */
    public function setPublishDateUtc(\DateTime $publishDateUtc) : Episode
    {
        $this->publishDateUtc = $publishDateUtc;

        return $this;
    }

    /**
     * @param string $size Size of the image to be fetched
     *
     * @return string
     */
    public function getImageUrl(string $size = null) : string
    {
        if ($size) {
            return $this->imageUrl . '?preset='.$size;
        } else {
            return $this->imageUrl;
        }
    }

    /**
     * @param string $imageUrl
     *
     * @return Episode
     */
    public function setImageUrl(string $imageUrl) : Episode
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @return DownloadPodFile
     */
    public function getDownloadPodFile() : DownloadPodFile
    {
        // Add empty pod file if it's not set (might not happen during deserialization)
        if (is_null($this->downloadPodFile)) {
            $this->downloadPodFile = new DownloadPodFile();
        }

        return $this->downloadPodFile;
    }

    /**
     * @param DownloadPodFile $downloadPodFile
     *
     * @return Episode
     */
    public function setDownloadPodFile(DownloadPodFile $downloadPodFile) : Episode
    {
        $this->downloadPodFile = $downloadPodFile;

        return $this;
    }
}
