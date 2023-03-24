<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Movie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviePostController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/addmovie", methods={"POST"})
     */
    public function post(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $movie = new Movie();
        $movie->setNameCinema($data['nameCinema']);
        $movie->setNameMovie($data['nameMovie']);

        $this->entityManager->flush();

        return $this->json(['id' => $movie->getId()]);
    }

}