<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Man;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManPostController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/addman", methods={"POST"})
     */
    public function post(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $man = new Man();
        $man->setSize($data['size']);
        $man->setStrong($data['strong']);

        $this->entityManager->flush();

        return $this->json(['id' => $man->getId()]);
    }
}
