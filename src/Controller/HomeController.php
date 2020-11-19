<?php

namespace App\Controller;

use App\Entity\MatchMaker;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {


        $match = new MatchMaker();

        $match->setPlayer1("Mickael")
        ->setPlayer2("JeanMi")
        ->setStatus(MatchMaker::STATUS_PLAYING);


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'match' => $match
        ]);
    }

/**
 * @Route("/name/{name}", name="displayName")
 */
public function displayName(Request $request): Response
{
    dump($name = $request->get('name'));

    return new Response($name);
}


}


