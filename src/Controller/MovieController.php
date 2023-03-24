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
        $book = $this->entityManager->getRepository(Movie::class)->find($id);


        if (!$book) {
            throw $this->createNotFoundException('Movie not found');
        }

        $data = [
            'id' => $book->getId(),
            'nameCinema' => $book->getNameCinema(),
            'nameMovie' => $book->getNameMovie(),
        ];

        return $this->json($data);
    }
}