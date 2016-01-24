<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class SpotifyAuthController extends Controller
{
    /**
     * @Route("/spotify/auth")
     */
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
}
