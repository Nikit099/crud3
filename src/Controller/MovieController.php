<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Movie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/getmovie/{id}", methods={"GET"})
     */
    public function getItem(int $id): Response
    {
        $movie = $this->entityManager->getRepository(Movie::class)->find($id);


        if (!$movie) {
            throw $this->createNotFoundException('Movie not found');
        }

        $data = [
            'id' => $movie->getId(),
            'nameCinema' => $movie->getNameCinema(),
            'nameMovie' => $movie->getNameMovie(),
        ];

        return $this->json($data);
    }
}
