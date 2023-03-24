<?php

namespace App\Controller;

use App\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviePatchController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/patchmovie/{id}", methods={"PATCH"})
     */
    public function patch(Request $request, int $id): Response
    {
        $movie = $this->entityManager->getRepository(Movie::class)->find($id);

        if (!$movie) {
            return $this->json(['error' => 'Movie not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['nameCinema'])) {
            $movie->setNameCinema($data['nameCinema']);
        }

        if (isset($data['nameMovie'])) {
            $movie->setNameMovie($data['nameMovie']);
        }

        $this->entityManager->flush();

        return $this->json(['message' => 'Movie updated successfully']);
    }
}