<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\News;
use App\Form\MitarbeiterInfoType;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    public function __construct(private readonly NewsRepository $newsRepository)
    {
    }

    #[Route('/admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/edit/{id?}', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit(Request $request, ?int $id): Response
    {
        $news = new News();
        if ($id !== null) {
            $news = $this->newsRepository->find($id);
        }

        $form = $this->createForm(type: MitarbeiterInfoType::class, data: $news);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $news = $form->getData();
            $this->newsRepository->entityManager->persist($news);
            $this->newsRepository->entityManager->flush();

            if ($id === null) {
                return $this->redirectToRoute('edit', ['id' => $news->id]);
            }
        }

        return $this->render(
            'admin/edit.html.twig',
            [
                'form' => $form->createView(),
                'id' => $news->id ?? null,
            ]
        );
    }
}
