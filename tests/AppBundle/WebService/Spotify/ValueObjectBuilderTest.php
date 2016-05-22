<?php
/**
 *
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace Tests\AppBundle\WebService\Spotify;

use AppBundle\WebService\Spotify\ValueObject\{
    AlbumSimplified, ArtistSimplified, Image, Playlist, Playlist\Owner, Playlist\TracksReference
};
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

    public function testBuildPlaylistOwner()
    {
        $owner = (object)[
            'external_urls' => (object)[
                'spotify' => 'http://open.spotify.com/...'
            ],
            'href' => 'https://api.spotify.com/v1/users/...',
            'id' => 'foo',
            'type' => 'user',
            'uri' => 'spotify:user:foo',
        ];

        $result = $this->valueObjectBuilder->buildPlaylistOwner($owner);
        
        $this->assertEquals(
            (array)$owner->external_urls,
            $result->getExternalUrls(),
            'External url should be set and be assoc. array'
        );

        $this->assertValueObjectPropertyEquals('href', $owner, $result);
        $this->assertValueObjectPropertyEquals('id', $owner, $result);
        $this->assertValueObjectPropertyEquals('type', $owner, $result);
        $this->assertValueObjectPropertyEquals('uri', $owner, $result);
    }

    public function testBuildPlaylistTracksReference()
    {
        $tracksReference = (object)[
            'href' => 'https://api.spotify.com/...',
            'total' => 30,
        ];

        $result = $this->valueObjectBuilder->buildPlaylistTracksReference($tracksReference);

        $this->assertEquals($tracksReference->href, $result->getHref(), 'Tracks reference href should be set');
        $this->assertEquals($tracksReference->total, $result->getTotal(), 'Tracks reference total should be set');
    }

    public function testBuildPlaylist()
    {
        $responseMock = json_decode(file_get_contents(__DIR__.'/response_test_data/user_playlists.json'))->items[0];

        $result = $this->valueObjectBuilder->buildPlaylist($responseMock);

        $this->assertEquals($responseMock->collaborative, $result->isCollaborative(), 'Is collaborative should be set');
        $this->assertValueObjectPropertyEquals('href', $responseMock, $result);
        $this->assertValueObjectPropertyEquals('id', $responseMock, $result);
        $this->assertValueObjectPropertyEquals('name', $responseMock, $result);
        $this->assertEquals($responseMock->public, $result->isPublic(), 'Is public should be set');
        $this->assertValueObjectPropertyEquals('snapshot_id', $responseMock, $result);
        $this->assertValueObjectPropertyEquals('type', $responseMock, $result);
        $this->assertValueObjectPropertyEquals('uri', $responseMock, $result);

        $this->assertEquals(
            (array)$responseMock->external_urls,
            $result->getExternalUrls(),
            'External hrefs should be set and be arrays'
        );
        $this->assertTrue($result->getOwner() instanceof Owner, 'Playlist owner should be an Owner');
        $this->assertTrue($result->getTracks() instanceof TracksReference, 'Tracks should be a TracksReference');
        $this->assertTrue(is_array($result->getImages()), 'Images should be an array');
        $this->assertTrue($result->getImages()[0] instanceof Image, 'First object in image array should be an Image');
    }

    public function testBuildUserPlaylistResponse()
    {
        $responseMock = json_decode(file_get_contents(__DIR__.'/response_test_data/user_playlists.json'));

        $result = $this->valueObjectBuilder->buildUserPlaylistResponse($responseMock);

        $this->assertValueObjectPropertyEquals('href', $responseMock, $result);
        $this->assertValueObjectPropertyEquals('limit', $responseMock, $result);
        $this->assertValueObjectPropertyEquals('next', $responseMock, $result);
        $this->assertValueObjectPropertyEquals('offset', $responseMock, $result);
        $this->assertValueObjectPropertyEquals('previous', $responseMock, $result);

        $this->assertTrue(is_array($result->getItems()), 'Response items should be an array');
        $this->assertTrue($result->getItems()[0] instanceof Playlist, 'First response item should be a Playlist');
    }

    /**
     * Check so a property is set
     *
     * @param string $property
     * @param object $expectedObject
     * @param object $result
     */
    protected function assertValueObjectPropertyEquals($property, $expectedObject, $result)
    {
        $propertyGetter = ucwords(str_replace('_', ' ', $property));
        $propertyGetter = 'get'.str_replace(' ', '', $propertyGetter);

        $this->assertEquals(
            $expectedObject->$property,
            call_user_func([$result, $propertyGetter]),
            "$property should be set"
        );
    }
}
