<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Man;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/getman/{id}", methods={"GET"})
     */
    public function getItem(int $id): Response
    {
        $man = $this->entityManager->getRepository(Man::class)->find($id);


        if (!$man) {
            throw $this->createNotFoundException('Man not found');
        }

        $data = [
            'id' => $man->getId(),
            'nameCinema' => $man->getNameCinema(),
            'nameMan' => $man->getNameMan(),
        ];

        return $this->json($data);
    }
}
