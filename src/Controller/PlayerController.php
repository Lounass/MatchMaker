<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * @Route("/player")
 * 
 */
class PlayerController extends AbstractController
{
    /**
     * @Route("/", name="player_index", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function index(PlayerRepository $playerRepository): Response
    {
        return $this->render('player/index.html.twig', [
            'players' => $playerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="player_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $player->setPassword($encoder-> encodePassword($player ,$player->getPassword() ));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($player);
            $entityManager->flush();

            return $this->redirectToRoute('player_index');
        }

        return $this->render('player/new.html.twig', [
            'player' => $player,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="player_show", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function show(Player $player): Response
    {
        return $this->render('player/show.html.twig', [
            'player' => $player,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="player_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function edit(Request $request, Player $player): Response
    {
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('player_index');
        }

        return $this->render('player/edit.html.twig', [
            'player' => $player,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="player_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function delete(Request $request, Player $player): Response
    {
        if ($this->isCsrfTokenValid('delete'.$player->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($player);
            $entityManager->flush();
        }

        return $this->redirectToRoute('player_index');
    }
}
