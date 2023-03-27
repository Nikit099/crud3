<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Movie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviePatchController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/patchmovie/{id}", methods={"PATCH"})
     */
    public function patch(Request $request, int $id): Response
    {
        $book = $this->entityManager->getRepository(Movie::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException('Нет такого фильма с id ' . $id);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['nameCinema'])) {
            $book->setNameCinema($data['nameCinema']);
        }

        if (isset($data['nameMovie'])) {
            $book->setNameMovie($data['nameMovie']);
        }

        $this->entityManager->flush();

        return $this->json(['message' => 'Фильмы обновлены']);
    }
}