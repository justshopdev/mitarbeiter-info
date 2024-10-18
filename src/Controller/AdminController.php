<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\News;
use App\Enum\FileTypeEnum;
use App\Form\NewsType;
use App\Repository\NewsRepository;
use App\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    public function __construct(
        private readonly NewsRepository $newsRepository,
        private readonly FileService $fileService,
    ) {
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
        if (null !== $id) {
            $news = $this->newsRepository->find($id) ?: $news;
        }

        $form = $this->createForm(type: NewsType::class, data: $news);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleAttachments($form->get('attachments'), $news);

            $this->newsRepository->entityManager->persist($news);
            $this->newsRepository->entityManager->flush();

            return $this->redirectToRoute('edit', ['id' => $news->id]);
        }

        return $this->render(
            'admin/edit.html.twig',
            [
                'form' => $form->createView(),
                'id' => $news->id ?? null,
            ]
        );
    }

    private function handleAttachments(FormInterface $attachmentForms, News $news): void
    {
        foreach ($attachmentForms as $attachmentForm) {
            $currentAttachment = $attachmentForm->getData();
            $delete = $attachmentForm->get('delete')->getData();
            if ($delete) {
                $news->attachments->removeElement($currentAttachment);
                $this->newsRepository->entityManager->remove($currentAttachment);
            }

            $uploadedFile = $attachmentForm->get('file')->getData();

            // is new upload
            if ($uploadedFile) {
                $result = $this->fileService->upload($uploadedFile, $news->title);

                $currentAttachment->type = FileTypeEnum::ATTACHMENT;
                $currentAttachment->lable = $result->lable;
                $currentAttachment->filename = $result->filename;
                $currentAttachment->dirname = $result->dirname;
                $currentAttachment->filetype = $result->filetype;
                $currentAttachment->filesize = $result->size;
                $currentAttachment->news = $news;
                $news->attachments->add($currentAttachment);
                $this->newsRepository->entityManager->persist($currentAttachment);
            }
        }
    }
}
