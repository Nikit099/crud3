<?php

namespace App\Controller;

use App\Entity\Man;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManDeleteController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/deleteman/{id}", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $man = $this->entityManager->getRepository(Man::class)->find($id);

        if (!$man) {
            throw $this->createNotFoundException('Man not found');
        }

        $this->entityManager->remove($man);
        $this->entityManager->flush();

        return $this->json(['message' => 'Man deleted']);
    }
}
