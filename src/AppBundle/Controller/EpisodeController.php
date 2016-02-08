<?php

namespace AppBundle\Controller;

use AppBundle\WebService\SR\Exception\InvalidEpisodeException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EpisodeController
 *
 * @Route("/episodes")
 */
class EpisodeController extends Controller
{
    /**
     * @param string $searchTerm
     * @param int $page
     *
     * @Route("/search", name="episodes_search")
     */
    public function searchAction(Request $request) : Response
    {
        $searchTerm = $request->query->get('q');
        $page = (int)$request->query->get('page') ?: 1;

        // Must enter a term
        if (is_null($searchTerm) || strlen($searchTerm) === 0) {
            throw $this->createNotFoundException("Not found. Did you enter a search term?");
        }

        $result = $this->get('sr_client')->searchForEpisode($searchTerm, $page);

        // Use another template if no results are found
        if ($result->getPagination()->getTotalHits() === 0) {
            return $this->render(':search:episodes_result_empty.html.twig', [
                'searchTerm' => $searchTerm,
                ]);
        }

        // Redirect to the highest existing page number if current page is more than that
        if ($page > $result->getPagination()->getTotalPages()) {
            return $this->redirectToRoute("episodes_search", [
                'q' => $searchTerm,
                'page' => $result->getPagination()->getTotalPages(),
            ]);
        }

        return $this->render(':search:episodes_results.html.twig', [
            'searchTerm' => $searchTerm,
            'page' => $page,
            'result' => $result,
        ]);
    }

    /**
     * @Route("/{id}", name="episode_single", requirements={"id": "\d+"})
     */
    public function singleEpisodeAction(int $id)
    {
        try {
            $episode = $this->get('sr_client')->getEpisode($id);
        } catch (InvalidEpisodeException $e) {
            return $this->render(
                ':episode_single:not_found.html.twig',
                ['id' => $id],
                new Response('', 404)
            );
        }

        return $this->render(
            ":episode_single:single.html.twig",
            [
                'episode' => $episode,
            ]
        );
    }

    /**
     * @Route("/{id}/tracks.json", name="episode_single_tracks", requirements={"id": "\d+"})
     */
    public function spotifyTracksAction(int $id)
    {
        try {
            $songs = $this->get('sr_client')->getEpisodePlaylist($id);
        } catch (InvalidEpisodeException $e) {
            $songs = [];
        }

        $tracks = $this->get('spotify_track_converter')->getSongsFromSpotify($songs);

        $serializedTracks = $this->get('jms_serializer')->serialize($tracks, 'json');

        return new Response($serializedTracks, 200, ['Content-Type' => 'application/json']);
    }
}
