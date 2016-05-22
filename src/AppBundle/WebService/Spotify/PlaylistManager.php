<?php
/**
 * Manages playlists through the spotifyApi
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\Spotify;

use AppBundle\Service\UserAwareSpotifyWebApi;
use SpotifyWebAPI\SpotifyWebAPIException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class PlaylistManager
{
    /** @var UserAwareSpotifyWebApi */
    protected $spotifyWebApi;
    /** @var ValueObjectBuilder */
    protected $valueObjectBuilder;

    /**
     * PlaylistManager constructor.
     *
     * @param UserAwareSpotifyWebApi $spotifyWebApi
     * @param ValueObjectBuilder $valueObjectBuilder
     */
    public function __construct(UserAwareSpotifyWebApi $spotifyWebApi, ValueObjectBuilder $valueObjectBuilder)
    {
        $this->spotifyWebApi = $spotifyWebApi;
        $this->valueObjectBuilder = $valueObjectBuilder;
    }


    /**
     * Gets the current user's playlists
     *
     * @param int $limit
     * @param int $offset
     *
     * @return Response\UserPlaylistResponse
     * @throws SpotifyWebAPIException
     */
    public function requestUserPlaylists($limit = 20, $offset = 0)
    {
        $rawResponse = $this->spotifyWebApi->getMyPlaylists(['limit' => $limit, 'offset' => $offset]);

        $response = $this->valueObjectBuilder->buildUserPlaylistResponse($rawResponse);

        return $response;
    }

    /**
     * Creates a new playlist
     *
     * @param string $name The playlist name
     * @param bool $public
     *
     * @return ValueObject\Playlist
     * @throws SpotifyWebAPIException
     */
    public function createPlaylist($name, $public = true)
    {
        $rawResponse = $this->spotifyWebApi->createUserPlaylist($this->spotifyWebApi->getSpotifyUserId(), [
            'name' => $name,
            'public' => $public,
        ]);

        $response = $this->valueObjectBuilder->buildPlaylist($rawResponse);

        return $response;
    }

    /**
     * Adds new tracks to a playlist
     *
     * @param string $playlistId
     * @param array $tracks
     *
     * @return bool
     */
    public function addTracksToPlaylist($playlistId, array $tracks)
    {
        $userId = $this->spotifyWebApi->getSpotifyUserId();

        $this->spotifyWebApi->addUserPlaylistTracks($userId, $playlistId, $tracks);

        return true;
    }
}
