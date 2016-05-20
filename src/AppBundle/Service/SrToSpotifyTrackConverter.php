<?php
/**
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\Service;

use AppBundle\WebService\Spotify\ValueObject\ArtistSimplified;
use AppBundle\WebService\Spotify\ValueObject\Track;
use AppBundle\Exception\NoTracksFoundException;
use AppBundle\WebService\SR\Responses\Entity\Song;

class SrToSpotifyTrackConverter
{
    /** @var SpotifyTrackFinder */
    private $spotifyTrackFinder;

    /**
     * SrToSpotifyTrackConverter constructor.
     *
     * @param SpotifyTrackFinder $spotifyTrackFinder
     */
    public function __construct(SpotifyTrackFinder $spotifyTrackFinder)
    {
        $this->spotifyTrackFinder = $spotifyTrackFinder;
    }

    /**
     * Gets all songs in array from Spotify based on the data from SR, or returns track objects with the known values
     *
     * @param Song[] $songs
     *
     * @return Track[]
     */
    public function getSongsFromSpotify(array $songs)
    {
        return array_map([$this, 'getSongFromSpotify'], $songs);
    }

    /**
     * Gets a song from Spotify based on the data from SR, or returns track objects with the known values
     *
     * @param Song $song
     *
     * @return Track
     */
    public function getSongFromSpotify(Song $song) : Track
    {
        try {
            $track = $this->spotifyTrackFinder->findTrack($this->getSearchTermFromSongObject($song));
        } catch (NoTracksFoundException $e) {
            // Set to default
            $artist = new ArtistSimplified();
            $artist->setName($song->getArtist());

            $track = new Track();
            $track
                ->setName($song->getTitle())
                ->setArtists([$artist]);
        }

        return $track;
    }

    /**
     * Get the search query to send to spotify from song data
     *
     * @param Song $song
     *
     * @return string
     */
    protected function getSearchTermFromSongObject(Song $song) : string
    {
        return "artist:{$song->getArtist()} track:{$song->getTitle()}";
    }
}
