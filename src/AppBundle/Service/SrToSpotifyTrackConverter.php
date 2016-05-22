<?php
/**
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\Service;

use AppBundle\WebService\Spotify\TrackFinder;
use AppBundle\WebService\Spotify\ValueObject\ArtistSimplified;
use AppBundle\WebService\Spotify\ValueObject\Track;
use AppBundle\Exception\NoTracksFoundException;
use AppBundle\WebService\SR\Responses\Entity\Song;

class SrToSpotifyTrackConverter
{
    /** @var TrackFinder */
    private $spotifyTrackFinder;

    /**
     * SrToSpotifyTrackConverter constructor.
     *
     * @param TrackFinder $spotifyTrackFinder
     */
    public function __construct(TrackFinder $spotifyTrackFinder)
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
    public function getSongsFromSpotify(array $songs, $includeMissing = true)
    {
        $tracks = [];
        foreach ($songs as $song) {
            $track = $this->getSongFromSpotify($song);

            // Track was found in spotify if it has a uri
            if ($track->getSpotifyUri() || (!$track->getSpotifyUri() && $includeMissing)) {
                array_push($tracks, $track);
            }
        }

        return $tracks;
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
            try {
                $track = $this->spotifyTrackFinder->findTrack($this->getLooseSearchTermFromSongObject($song));
            } catch (NoTracksFoundException $e) {
                // Set to default
                $artist = new ArtistSimplified();
                $artist->setName($song->getArtist());

                $track = new Track();
                $track
                    ->setName($song->getTitle())
                    ->setArtists([$artist]);
            }
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
        return "artist:{$this->removeUnnecessaryCharacters($song->getArtist())} track:{$this->removeUnnecessaryCharacters($song->getTitle())}";
    }

    /**
     * Get the search query to send to spotify from song data, but don't specify artist & track
     *
     * @param Song $song
     *
     * @return string
     */
    protected function getLooseSearchTermFromSongObject(Song $song) : string
    {
        return "{$this->removeUnnecessaryCharacters($song->getArtist())} {$this->removeUnnecessaryCharacters($song->getTitle())}";
    }

    /**
     * Remove unnecessary characters (such as &, (, ) etc) to widen search
     *
     * @param string $string
     *
     * @return string
     */
    protected function removeUnnecessaryCharacters(string $string) : string
    {
//        return $string;
        return str_replace(['(', ')', '-', '&', ',', '.'], ' ', $string);
    }
}
