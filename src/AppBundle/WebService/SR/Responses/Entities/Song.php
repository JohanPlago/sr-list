<?php
/**
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\SR\Responses\Entities;

use JMS\Serializer\Annotation as Jms;

class Song
{
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
    private $artist;

    /**
     * @var string
     *
     * @Jms\Type("string")
     */
    private $composer;

    /**
     * @var string
     *
     * @Jms\Type("string")
     * @Jms\SerializedName("recordlabel")
     */
    private $recordLabel;

    /**
     * @var string
     *
     * @Jms\Type("string")
     */
    private $lyricist;

    /**
     * @var \DateTime
     *
     * @Jms\Type("DateTime<'\/\D\a\t\e\(U\)\/'>")
     * @Jms\SerializedName("starttimeutc")
     */
    private $startTimeUtc;

    /**
     * @var \DateTime
     *
     * @Jms\Type("DateTime<'\/\D\a\t\e\(U\)\/'>")
     * @Jms\SerializedName("stoptimeutc")
     */
    private $stopTimeUtc;

    /**
     * The date is sent in milliseconds so we need to fix that...
     *
     * @Jms\PostDeserialize
     */
    public function dateTimeFromMilliseconds()
    {
        if ($this->startTimeUtc instanceof \DateTime) {
            $originalTimestamp = (int)$this->startTimeUtc->format('U');
            $this->startTimeUtc = \DateTime::createFromFormat('U', floor($originalTimestamp / 1000));
        }

        if ($this->stopTimeUtc instanceof \DateTime) {
            $originalTimestamp = (int)$this->stopTimeUtc->format('U');
            $this->stopTimeUtc = \DateTime::createFromFormat('U', floor($originalTimestamp / 1000));
        }
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
     * @return Song
     */
    public function setTitle(string $title) : Song
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
     * @return Song
     */
    public function setDescription(string $description) : Song
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getArtist() : string
    {
        return $this->artist;
    }

    /**
     * @param string $artist
     *
     * @return Song
     */
    public function setArtist(string $artist) : Song
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * @return string
     */
    public function getComposer() : string
    {
        return $this->composer;
    }

    /**
     * @param string $composer
     *
     * @return Song
     */
    public function setComposer(string $composer) : Song
    {
        $this->composer = $composer;

        return $this;
    }

    /**
     * @return string
     */
    public function getRecordLabel() : string
    {
        return $this->recordLabel;
    }

    /**
     * @param string $recordLabel
     *
     * @return Song
     */
    public function setRecordLabel(string $recordLabel) : Song
    {
        $this->recordLabel = $recordLabel;

        return $this;
    }

    /**
     * @return string
     */
    public function getLyricist() : string
    {
        return $this->lyricist;
    }

    /**
     * @param string $lyricist
     *
     * @return Song
     */
    public function setLyricist(string $lyricist) : Song
    {
        $this->lyricist = $lyricist;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartTimeUtc() : \DateTime
    {
        return $this->startTimeUtc;
    }

    /**
     * @param \DateTime $startTimeUtc
     *
     * @return Song
     */
    public function setStartTimeUtc(\DateTime $startTimeUtc) : Song
    {
        $this->startTimeUtc = $startTimeUtc;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStopTimeUtc() : \DateTime
    {
        return $this->stopTimeUtc;
    }

    /**
     * @param \DateTime $stopTimeUtc
     *
     * @return Song
     */
    public function setStopTimeUtc(\DateTime $stopTimeUtc) : Song
    {
        $this->stopTimeUtc = $stopTimeUtc;

        return $this;
    }
}
