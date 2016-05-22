<?php
/**
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\Spotify;

use AppBundle\WebService\Spotify\ValueObject\Track;
use AppBundle\Exception\NoTracksFoundException;
use SpotifyWebAPI\SpotifyWebAPI;

class TrackFinder
{
    /** @var SpotifyWebAPI */
    private $spotifyWebApi;
    /** @var ValueObjectBuilder */
    private $valueObjectBuilder;

    /**
     * TrackFinder constructor.
     *
     * @param SpotifyWebAPI $spotifyWebApi
     * @param $valueObjectBuilder
     */
    public function __construct(SpotifyWebAPI $spotifyWebApi, ValueObjectBuilder $valueObjectBuilder)
    {
        $this->spotifyWebApi = $spotifyWebApi;
        $this->valueObjectBuilder = $valueObjectBuilder;
    }

    /**
     * Search for a track and build the response objects
     *
     * @param string $string
     *
     * @return Track
     */
    public function findTrack(string $string)
    {
        $result = $this->spotifyWebApi->search($string, 'track');

        if (count($result->tracks->items) === 0) {
            throw NoTracksFoundException::emptyResult();
        }

        $firstItem = $result->tracks->items[0];

        $images = $this->valueObjectBuilder->buildImages($firstItem->album->images);
        $album = $this->valueObjectBuilder->buildAlbumSimplified($firstItem->album, $images);
        $artists = $this->valueObjectBuilder->buildArtistsSimplified($firstItem->artists);

        $track = $this->valueObjectBuilder->buildTrack($firstItem, $album, $artists);

        return $track;
    }
}
