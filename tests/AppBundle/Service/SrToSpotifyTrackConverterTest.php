<?php
/**
 *
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */


namespace Tests\AppBundle\Service;


use AppBundle\WebService\Spotify\ValueObject\Track;
use AppBundle\Exception\NoTracksFoundException;
use AppBundle\Service\{
    AppBundle\WebService\Spotify\SpotifyTrackFinder,
    SrToSpotifyTrackConverter
};
use AppBundle\WebService\SR\Responses\Entity\Song;

class SrToSpotifyTrackConverterTest extends \PHPUnit_Framework_TestCase
{
    /** @var \AppBundle\WebService\Spotify\SpotifyTrackFinder|\PHPUnit_Framework_MockObject_MockObject */
    private $trackFinder;
    /** @var SrToSpotifyTrackConverter */
    private $trackConverter;

    public function setUp()
    {
        $this->trackFinder = $this->getMockBuilder(\AppBundle\WebService\Spotify\TrackFinder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->trackConverter = new SrToSpotifyTrackConverter($this->trackFinder);
    }

    public function testGetSongFromSpotify()
    {
        $song = new Song();
        $song
            ->setTitle('Foo song')
            ->setArtist('Bar');
        $spotifyTrack = new Track();

        $this->trackFinder->expects($this->once())
            ->method('findTrack')
            ->with($this->logicalAnd(
                $this->stringContains($song->getTitle()),
                $this->stringContains($song->getArtist())
            ))
            ->willReturn($spotifyTrack);

        $result = $this->trackConverter->getSongFromSpotify($song);

        $this->assertSame($spotifyTrack, $result, "Returned track should be the spotify track");
    }

    public function testGetSongFromSpotifyReturnsDefaultOnNotFound()
    {
        $song = new Song();
        $song
            ->setTitle('Foo song')
            ->setArtist('Bar');

        $this->trackFinder->method('findTrack')
            ->willThrowException(NoTracksFoundException::emptyResult());

        $result = $this->trackConverter->getSongFromSpotify($song);

        $this->assertEquals(
            $song->getTitle(),
            $result->getName(),
            'Name should be set to default'
        );
        $this->assertEquals(
            $song->getArtist(),
            $result->getArtists()[0]->getName(),
            'Artist should be set to default'
        );
    }
}
