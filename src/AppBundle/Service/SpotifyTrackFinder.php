<?php
/**
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\Service;

use AppBundle\Entity\Spotify\{
    AlbumSimplified,
    ArtistSimplified,
    Image,
    Track
};
use AppBundle\Exception\NoTracksFoundException;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyTrackFinder
{
    /** @var SpotifyWebAPI */
    private $spotifyWebApi;

    /**
     * SpotifyTrackFinder constructor.
     *
     * @param SpotifyWebAPI $spotifyWebApi
     */
    public function __construct(SpotifyWebAPI $spotifyWebApi)
    {
        $this->spotifyWebApi = $spotifyWebApi;
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

        $images = $this->buildImages($firstItem->album->images);
        $album = $this->buildAlbum($firstItem->album, $images);
        $artists = $this->buildArtists($firstItem->artists);

        $track = $this->buildTrack($firstItem, $album, $artists);

        return $track;
    }

    /**
     * Create a track object from result
     *
     * @param object $item
     * @param AlbumSimplified $album
     * @param array $artists
     *
     * @return Track
     */
    public function buildTrack($item, AlbumSimplified $album, array $artists)
    {
        $track = new Track();

        $track
            ->setId($item->id)
            ->setName($item->name)
            ->setSpotifyUri($item->uri)
            ->setSpotifyHref($item->href)
            ->setAlbum($album)
            ->setArtists($artists);

        return $track;
    }

    /**
     * Create image objects from result
     *
     * @param array $images
     *
     * @return Image[]
     */
    public function buildImages(array $images) : array
    {
        $returnImages = array_map(
            function ($image) {
                $newImage = new Image();

                $newImage
                    ->setHeight($image->height)
                    ->setUrl($image->url)
                    ->setWidth($image->width);

                return $newImage;
            },
            $images
        );

        return $returnImages;
    }

    /**
     * Create an album from result
     *
     * @param object $album
     * @param Image[] $images
     *
     * @return AlbumSimplified
     */
    public function buildAlbum($album, array $images) : AlbumSimplified
    {
        $returnAlbum = new AlbumSimplified();

        $returnAlbum
            ->setId($album->id)
            ->setName($album->name)
            ->setSpotifyHref($album->href)
            ->setSpotifyUri($album->uri)
            ->setImages($images);

        return $returnAlbum;
    }

    /**
     * Create artist objects from results
     *
     * @param array $artists
     *
     * @return ArtistSimplified[]
     */
    public function buildArtists(array $artists) : array
    {
        $returnArtists = array_map(
            function ($artist) {
                $newArtist = new ArtistSimplified();

                $newArtist
                    ->setId($artist->id)
                    ->setName($artist->name)
                    ->setSpotifyHref($artist->href)
                    ->setSpotifyUri($artist->uri);

                return $newArtist;
            },
            $artists
        );

        return $returnArtists;
    }
}
