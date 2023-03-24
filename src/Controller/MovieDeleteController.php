<?php

namespace App\Controller;

use App\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieDeleteController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/deletemovie/{id}", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $movie = $this->entityManager->getRepository(Movie::class)->find($id);

        if (!$movie) {
            throw $this->createNotFoundException('Movie not found');
        }

        $this->entityManager->remove($movie);
        $this->entityManager->flush();

        return $this->json(['message' => 'Movie deleted']);
    }
}
