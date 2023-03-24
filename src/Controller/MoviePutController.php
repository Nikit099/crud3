<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Movie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviePutController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/updatemovie/{id}", methods={"PUT"})
     */
    public function put(Request $request, $id): Response
    {
        $movie = $this->entityManager->getRepository(Movie::class)->find($id);

        if (!$movie) {
            throw $this->createNotFoundException('No movie found for id ' . $id);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['nameMovie'])) {
            $movie->setnNmeMovie($data['nameMovie']);
        }

        if (isset($data['nameCinema'])) {
            $movie->setNameCinema($data['nameCinema']);
        }
        $this->entityManager->flush();
        return $this->json(['id' => $movie->getId()]);
    }

}