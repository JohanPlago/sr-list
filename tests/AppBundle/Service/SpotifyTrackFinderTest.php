<?php
/**
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace Tests\AppBundle\Service;

use AppBundle\Entity\Spotify\{
    AlbumSimplified,
    ArtistSimplified,
    Track
};
use AppBundle\Service\SpotifyTrackFinder;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyTrackFinderTest extends \PHPUnit_Framework_TestCase
{
    /** @var SpotifyWebAPI|\PHPUnit_Framework_MockObject_MockObject */
    private $apiStub;
    /** @var SpotifyTrackFinder */
    private $trackFinder;

    public function setUp()
    {
        $this->apiStub = $this->getMockBuilder(SpotifyWebAPI::class)
                              ->disableOriginalConstructor()
                              ->getMock();
        $this->trackFinder = new SpotifyTrackFinder($this->apiStub);
    }

    public function testBuildTrack()
    {
        $track = (object)[
            'id'   => 'someid',
            'name' => 'Someone like you',
            'href' => 'http://aoeuaoeu',
            'uri'  => 'testuri:test',
        ];

        $result = $this->trackFinder->buildTrack($track, new AlbumSimplified(), [new ArtistSimplified()]);

        $this->assertEquals(
            $track->id,
            $result->getId(),
            'Track id should be set'
        );
        $this->assertEquals(
            $track->name,
            $result->getName(),
            'Track name should be set'
        );
        $this->assertEquals(
            $track->href,
            $result->getSpotifyHref(),
            'Track href should be set'
        );
        $this->assertEquals(
            $track->uri,
            $result->getSpotifyUri(),
            'Track URI should be set'
        );

        $this->assertInstanceOf(AlbumSimplified::class, $result->getAlbum(), 'Album should be set');
        $this->assertInstanceOf(ArtistSimplified::class, $result->getArtists()[0], 'Artist(s) should be set');
    }

    public function testBuildImages()
    {
        $image1 = (object)[
            'width'  => 101,
            'height' => 102,
            'url'    => 'http://example.tld/test.png',
        ];
        $image2 = clone $image1;

        $result = $this->trackFinder->buildImages([$image1, $image2]);

        $this->assertCount(2, $result, 'Number of result should equal number of inputted images');

        $this->assertEquals(
            $image1->height,
            $result[0]->getHeight(),
            'Album image height should be set'
        );
        $this->assertEquals(
            $image1->width,
            $result[0]->getWidth(),
            'Album image width should be set'
        );
        $this->assertEquals(
            $image1->url,
            $result[0]->getUrl(),
            'Album image url should be set'
        );
    }

    public function testBuildAlbum()
    {
        $album = (object)[
            'id'   => 'testid',
            'name' => 'I am someone',
            'uri'  => 'nonense:test',
            'href' => 'http://...',
        ];

        $result = $this->trackFinder->buildAlbum($album, []);

        $this->assertEquals(
            $album->id,
            $result->getId(),
            'Album id should be set'
        );
        $this->assertEquals(
            $album->name,
            $result->getName(),
            'Album name should be set'
        );
        $this->assertEquals(
            $album->uri,
            $result->getSpotifyUri(),
            'Album uri should be set'
        );
        $this->assertEquals(
            $album->href,
            $result->getSpotifyHref(),
            'Album href should be set'
        );
    }

    public function testBuildArtists()
    {
        $artist1 = (object)[
            'id'   => 'someid',
            'name' => 'Avicii',
            'href' => 'http://...',
            'uri'  => 'nonsense:test',
        ];
        $artist2 = clone $artist1;
        $result = $this->trackFinder->buildArtists([$artist1, $artist2]);

        $this->assertCount(2, $result, 'Number of result should equal number of inputted artists');

        $this->assertEquals(
            $artist1->id,
            $result[0]->getId(),
            'Artist id should be set'
        );
        $this->assertEquals(
            $artist1->name,
            $result[0]->getName(),
            'Artist name should be set'
        );
        $this->assertEquals(
            $artist1->uri,
            $result[0]->getSpotifyUri(),
            'Artist uri should be set'
        );
        $this->assertEquals(
            $artist1->href,
            $result[0]->getSpotifyHref(),
            'Artist href should be set'
        );
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
