<?php
/**
 * Tests the playlist manager
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace Tests\AppBundle\WebService\Spotify;


use AppBundle\Service\UserAwareSpotifyWebApi;
use AppBundle\WebService\Spotify\PlaylistManager;
use AppBundle\WebService\Spotify\Response\UserPlaylistResponse;
use AppBundle\WebService\Spotify\ValueObject\Playlist;
use AppBundle\WebService\Spotify\ValueObjectBuilder;

class PlaylistManagerTest extends \PHPUnit_Framework_TestCase
{
    /** @var UserAwareSpotifyWebApi|\PHPUnit_Framework_MockObject_MockObject */
    private $apiStub;
    /** @var PlaylistManager */
    private $playlistManager;

    public function setUp()
    {
        $this->apiStub = $this->getMockBuilder(UserAwareSpotifyWebApi::class)
                              ->disableOriginalConstructor()
                              ->getMock();
        $this->playlistManager = new PlaylistManager($this->apiStub, new ValueObjectBuilder());
    }

    public function testRequestUserPlaylists()
    {
        $this->apiStub
            ->expects($this->once())
            ->method('getMyPlaylists')
            ->willReturn(json_decode(file_get_contents(__DIR__.'/response_test_data/user_playlists.json')));

        $playlistResponse = $this->playlistManager->requestUserPlaylists(20, 0);

        $this->assertTrue($playlistResponse instanceof UserPlaylistResponse, 'requestUserPlaylists should return a playlist response');
    }

    public function testCreatePlaylist()
    {
        $mockResponse = json_decode(file_get_contents(__DIR__.'/response_test_data/user_playlists.json'))->items[0];
        $this->apiStub
            ->method('getSpotifyUserId')
            ->willReturn('foo');
        $this->apiStub
            ->expects($this->once())
            ->method('createUserPlaylist')
            ->with('foo', ['name' => 'bar', 'public' => false])
            ->willReturn($mockResponse);

        $result = $this->playlistManager->createPlaylist('bar', false);

        $this->assertTrue($result instanceof Playlist, 'Result should be a playlist');
    }

    public function testAddTracksToPlaylist()
    {
        $mockResponse = (object)[
            'snapshot_id' => 'abc123'
        ];

        $tracksToAdd = ['some:track:uri', 'some:other:track', 'some:third:track'];

        $this->apiStub
            ->method('getSpotifyUserId')
            ->willReturn('foo');
        $this->apiStub
            ->expects($this->once())
            ->method('addUserPlaylistTracks')
            ->with('foo', 'playlistId', $tracksToAdd)
            ->willReturn($mockResponse);

        $result = $this->playlistManager->addTracksToPlaylist('playlistId', $tracksToAdd);

        $this->assertTrue($result);
    }
}
