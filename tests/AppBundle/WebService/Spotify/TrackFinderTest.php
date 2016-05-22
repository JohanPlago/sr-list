<?php
/**
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace Tests\AppBundle\WebService\Spotify;

use AppBundle\WebService\Spotify\ValueObject\{
    AlbumSimplified,
    ArtistSimplified,
    Track
};
use AppBundle\WebService\Spotify\TrackFinder;
use AppBundle\WebService\Spotify\ValueObjectBuilder;
use SpotifyWebAPI\SpotifyWebAPI;

class TrackFinderTest extends \PHPUnit_Framework_TestCase
{
    /** @var SpotifyWebAPI|\PHPUnit_Framework_MockObject_MockObject */
    private $apiStub;
    /** @var TrackFinder */
    private $trackFinder;

    public function setUp()
    {
        $this->apiStub = $this->getMockBuilder(SpotifyWebAPI::class)
                              ->disableOriginalConstructor()
                              ->getMock();
        $this->trackFinder = new TrackFinder($this->apiStub, new ValueObjectBuilder());
    }

    public function testFindTrack()
    {
        $searchTerm = 'abba';
        $this->apiStub->expects($this->once())
                      ->method('search')
                      ->with($searchTerm, 'track')
                      ->willReturn($this->getSearchTrackResponseStub());

        $result = $this->trackFinder->findTrack($searchTerm);

        $this->assertInstanceOf(Track::class, $result, 'Result should be a Track');
    }


    /**
     * @expectedException \AppBundle\Exception\NoTracksFoundException
     */
    public function testFindTrackEmptyResultThrowsError()
    {
        $result = (object)[
            'tracks' => (object)[
                'items' => [],
            ],
        ];

        $this->apiStub->method('search')
                      ->willReturn($result);

        $this->trackFinder->findTrack('track that doesnt exist');
    }

    protected function getSearchTrackResponseStub()
    {
        return json_decode(file_get_contents(__DIR__.'/response_test_data/search_track.json'), false);
    }
}
