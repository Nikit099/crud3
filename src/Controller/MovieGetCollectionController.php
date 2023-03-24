<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Movie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieGetCollectionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/getcollectionmovie", methods={"GET"})
     */
    public function getCollection(Request $request): Response
    {
        $movies = $this->entityManager->getRepository(Movie::class)->findAll();

        $data = [];
        foreach ($movies as $movie) {
            $data[] = [
                'id' => $movie->getId(),
                'nameCinema' => $movie->getNameCinema(),
                'nameMovie' => $movie->getNameMovie(),
            ];
        }

        return $this->json($data);
    }

}