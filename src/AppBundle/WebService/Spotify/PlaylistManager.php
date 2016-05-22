<?php
/**
 * Manages playlists through the spotifyApi
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\Spotify;

use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\SpotifyWebAPIException;

class PlaylistManager
{
    /** @var SpotifyWebAPI */
    protected $spotifyWebApi;
    /** @var ValueObjectBuilder */
    protected $valueObjectBuilder;

    /**
     * PlaylistManager constructor.
     *
     * @param SpotifyWebAPI $spotifyWebApi
     */
    public function __construct(SpotifyWebAPI $spotifyWebApi, ValueObjectBuilder $valueObjectBuilder)
    {
        $this->spotifyWebApi = $spotifyWebApi;
        $this->valueObjectBuilder = $valueObjectBuilder;
    }

    /**
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
}
