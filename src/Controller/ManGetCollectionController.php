<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Man;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManGetCollectionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/getcollectionman", methods={"GET"})
     */
    public function getCollection(Request $request): Response
    {
        $mans = $this->entityManager->getRepository(Man::class)->findAll();

        $data = [];
        foreach ($mans as $man) {
            $data[] = [
                'id' => $man->getId(),
                'nameCinema' => $man->getNameCinema(),
                'nameMan' => $man->getNameMan(),
            ];
        }

        return $this->json($data);
    }
}
