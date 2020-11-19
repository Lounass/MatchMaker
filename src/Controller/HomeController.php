<?php

namespace App\Controller;

use App\Entity\MatchMaker;
use App\Entity\Player;
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

        $playerA = new Player();
        $playerA->setUsername("Bobby");

        


  


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController'

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


