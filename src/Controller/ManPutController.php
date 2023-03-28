<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Man;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManPutController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/updateman/{id}", methods={"PUT"})
     */
    public function put(Request $request, $id): Response
    {
        $man = $this->entityManager->getRepository(Man::class)->find($id);

        if (!$man) {
            throw $this->createNotFoundException('Мужчины с такой штучкой id нет' . $id);
        }

        $data = json_decode($request->getContent(), true);

        $size = isset($data['size']) ? $data['size'] : null;
        $strong = isset($data['strong']) ? $data['strong'] : null;

        $man->setSize($size);
        $man->setStrong($strong);

        $this->entityManager->flush();

        return $this->json(['id' => $man->getId()]);
    }
}
