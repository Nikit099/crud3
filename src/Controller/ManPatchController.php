<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Man;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManPatchController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/patchman/{id}", methods={"PATCH"})
     */
    public function patch(Request $request, int $id): Response
    {
        $man = $this->entityManager->getRepository(Man::class)->find($id);

        if (!$man) {
            throw $this->createNotFoundException('Мужчины с такой штучкой id нет ' . $id);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['size'])) {
            $man->setSize($data['size']);
        }

        if (isset($data['strong'])) {
            $man->setStrong($data['strong']);
        }

        $this->entityManager->flush();

        return $this->json(['message' => 'Произошло обновление Мужчин']);
    }
}
