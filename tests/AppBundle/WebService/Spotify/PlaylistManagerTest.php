<?php
/**
 * Tests the playlist manager
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace Tests\AppBundle\WebService\Spotify;


use AppBundle\WebService\Spotify\PlaylistManager;
use AppBundle\WebService\Spotify\Response\UserPlaylistResponse;
use AppBundle\WebService\Spotify\ValueObjectBuilder;
use SpotifyWebAPI\SpotifyWebAPI;

class PlaylistManagerTest extends \PHPUnit_Framework_TestCase
{
    /** @var SpotifyWebAPI|\PHPUnit_Framework_MockObject_MockObject */
    private $apiStub;
    /** @var PlaylistManager */
    private $playlistManager;

    public function setUp()
    {
        $this->apiStub = $this->getMockBuilder(SpotifyWebAPI::class)
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
}
