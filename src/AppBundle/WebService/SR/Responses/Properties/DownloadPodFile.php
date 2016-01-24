<?php
/**
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\SR\Responses\Properties;

use JMS\Serializer\Annotation as Jms;

/**
 * Class DownloadPodFile
 */
class DownloadPodFile
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
     */
    private $url;

    /**
     * @var integer
     *
     * @Jms\Type("integer")
     */
    private $duration;

    /**
     * @var \DateTime
     *
     * @Jms\Type("DateTime<'\/\D\a\t\e\(U\)\/'>")
     * @Jms\SerializedName("publishdateutc")
     */
    private $publishDateUtc;

    /**
     * @var integer
     *
     * @Jms\Type("integer")
     * @Jms\SerializedName("filesizeinbytes")
     */
    private $fileSizeInBytes;

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
     * @return DownloadPodFile
     */
    public function setSrId(int $srId) : DownloadPodFile
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
     * @return DownloadPodFile
     */
    public function setTitle(string $title) : DownloadPodFile
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
     * @return DownloadPodFile
     */
    public function setDescription(string $description) : DownloadPodFile
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl() : string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return DownloadPodFile
     */
    public function setUrl(string $url) : DownloadPodFile
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return int
     */
    public function getDuration() : int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     *
     * @return DownloadPodFile
     */
    public function setDuration(int $duration) : DownloadPodFile
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getPublishDateUtc() : \DateTime
    {
        return $this->publishDateUtc;
    }

    /**
     * @param DateTime $publishDateUtc
     *
     * @return DownloadPodFile
     */
    public function setPublishDateUtc(\DateTime $publishDateUtc) : DownloadPodFile
    {
        $this->publishDateUtc = $publishDateUtc;

        return $this;
    }

    /**
     * @return int
     */
    public function getFileSizeInBytes() : int
    {
        return $this->fileSizeInBytes;
    }

    /**
     * @param int $fileSizeInBytes
     *
     * @return DownloadPodFile
     */
    public function setFileSizeInBytes(int $fileSizeInBytes) : DownloadPodFile
    {
        $this->fileSizeInBytes = $fileSizeInBytes;

        return $this;
    }
}
