<?php
/**
 * Builds value objects from web api responses
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\Spotify;

use AppBundle\WebService\Spotify\ValueObject\{
    AlbumSimplified,
    ArtistSimplified,
    Image,
    Track
};

class ValueObjectBuilder
{

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
    public function buildAlbumSimplified($album, array $images) : AlbumSimplified
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
    public function buildArtistsSimplified(array $artists) : array
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
