<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     * @Route("/{id}", name="single_episode", requirements={id: "\d+"})
     */
    public function singleEpisodeAction()
    {

    }
}
