<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SpotifyUser;
use SpotifyWebAPI\SpotifyWebAPIException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/spotify")
 */
class SpotifyLoginController extends Controller
{
    /**
     * @Route("/jag", name="spotify_profile")
     */
    public function myPageAction()
    {
        $spotifyApiClient = $this->get('spotify.web_api');

        return $this->render(
            ':spotify:me.html.twig', [
        ]);
    }
}
