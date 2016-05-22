<?php
/**
 *
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace Tests\AppBundle\WebService\Spotify;

use AppBundle\WebService\Spotify\ValueObject\AlbumSimplified;
use AppBundle\WebService\Spotify\ValueObject\ArtistSimplified;
use AppBundle\WebService\Spotify\ValueObjectBuilder;

class ValueObjectBuilderTest extends \PHPUnit_Framework_TestCase
{
    /** @var ValueObjectBuilder */
    protected $valueObjectBuilder;

    public function setUp()
    {
        $this->valueObjectBuilder = new ValueObjectBuilder();
    }
    public function testBuildTrack()
    {
        $track = (object)[
            'id'   => 'someid',
            'name' => 'Someone like you',
            'href' => 'http://aoeuaoeu',
            'uri'  => 'testuri:test',
        ];

        $result = $this->valueObjectBuilder->buildTrack($track, new AlbumSimplified(), [new ArtistSimplified()]);

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

        $result = $this->valueObjectBuilder->buildImages([$image1, $image2]);

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

    public function testBuildAlbumSimplified()
    {
        $album = (object)[
            'id'   => 'testid',
            'name' => 'I am someone',
            'uri'  => 'nonense:test',
            'href' => 'http://...',
        ];

        $result = $this->valueObjectBuilder->buildAlbumSimplified($album, []);

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

    public function testBuildArtistsSimplified()
    {
        $artist1 = (object)[
            'id'   => 'someid',
            'name' => 'Avicii',
            'href' => 'http://...',
            'uri'  => 'nonsense:test',
        ];
        $artist2 = clone $artist1;
        $result = $this->valueObjectBuilder->buildArtistsSimplified([$artist1, $artist2]);

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

}
