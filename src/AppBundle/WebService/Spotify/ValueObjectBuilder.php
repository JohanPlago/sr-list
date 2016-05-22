<?php
/**
 * Builds value objects from web api responses
 *
 * @author Johan Palmfjord <johan.plago@gmail.com>
 * @copyright Johan Palmfjord, 2016
 * @version 1.0
 */

namespace AppBundle\WebService\Spotify;

use AppBundle\WebService\Spotify\Response\UserPlaylistResponse;
use AppBundle\WebService\Spotify\ValueObject\{
    AlbumSimplified, ArtistSimplified, Image, Playlist, Track
};

class ValueObjectBuilder
{
    /**
     * @param $response
     *
     * @return UserPlaylistResponse
     */
    public function buildUserPlaylistResponse($response)
    {
        $result = new  UserPlaylistResponse();
        $result
            ->setHref($response->href)
            ->setItems(array_map([$this, 'buildPlaylist'], $response->items))
            ->setLimit($response->limit)
            ->setNext($response->next)
            ->setOffset($response->offset)
            ->setPrevious($response->previous)
            ->setTotal($response->total);

        return $result;
    }

    /**
     * @param $playlist
     *
     * @return Playlist
     */
    public function buildPlaylist($playlist) : Playlist
    {
        $result = new Playlist();
        $result
            ->setCollaborative($playlist->collaborative)
            ->setExternalUrls((array)$playlist->external_urls)
            ->setHref($playlist->href)
            ->setId($playlist->id)
            ->setImages($this->buildImages($playlist->images))
            ->setName($playlist->name)
            ->setOwner($this->buildPlaylistOwner($playlist->owner))
            ->setPublic($playlist->public)
            ->setSnapshotId($playlist->snapshot_id)
            ->setTracks($this->buildPlaylistTracksReference($playlist->tracks))
            ->setType($playlist->type)
            ->setUri($playlist->uri);

        return $result;
    }

    /**
     * @param object $owner
     *
     * @return Playlist\Owner
     */
    public function buildPlaylistOwner($owner)
    {
        $result = new Playlist\Owner();

        $result
            ->setExternalUrls((array)$owner->external_urls)
            ->setHref($owner->href)
            ->setId($owner->id)
            ->setType($owner->type)
            ->setUri($owner->uri);

        return $result;
    }

    /**
     * @param object $tracksReference
     *
     * @return Playlist\TracksReference
     */
    public function buildPlaylistTracksReference($tracksReference)
    {
        $result = new Playlist\TracksReference();

        $result
            ->setHref($tracksReference->href)
            ->setTotal($tracksReference->total);

        return $result;
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
