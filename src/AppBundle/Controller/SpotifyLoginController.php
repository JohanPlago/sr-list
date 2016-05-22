<?php

namespace AppBundle\Controller;

use SpotifyWebAPI\SpotifyWebAPIException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\{
    Request, Response
};
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/spotify")
 */
class SpotifyLoginController extends Controller
{
    /**
     * @Route("/jag", name="spotify_profile")
     */
    public function myPageAction(Request $request)
    {
        $limit = 50;
        $page = (int)$request->query->get('playlist-page');
        $offset = ($page > 0 ? $page : 1) * $limit;

        try {
            $playlistResponse = $this->get('spotify.playlist_manager')->requestUserPlaylists($limit, $offset);
        } catch (SpotifyWebAPIException $e) {
            $playlistResponse = [];
            $failedToFetchPlaylists = true;
        }

        return $this->render(
            ':spotify:me.html.twig',
            [
                'playlistResponse' => $playlistResponse,
                'failedToFetchPlaylists' => isset($failedToFetchPlaylists),
            ]
        );
    }
}
