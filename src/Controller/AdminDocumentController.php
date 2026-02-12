<?php

namespace App\Controller;

use App\Entity\Document;
use App\Form\DocumentType;
use App\Repository\DocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/document')]
final class AdminDocumentController extends AbstractController
{
    #[Route(name: 'app_admin_document_index', methods: ['GET'])]
    public function index(DocumentRepository $documentRepository): Response
    {
        return $this->render('admin_document/index.html.twig', [
            'documents' => $documentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_document_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $document = new Document();
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $documentFile = $form->get('documentFile')->getData();
            if ($documentFile) {
                $originalFilename = pathinfo($documentFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$documentFile->guessExtension();

                try {
                    $documentFile->move(
                        $this->getParameter('kernel.project_dir').'/public/uploads/documents',
                        $newFilename
                    );
                    $document->setFilename('uploads/documents/' . $newFilename);
                } catch (FileException $e) {
                    // Handle exception
                }
            }
            
            $document->setUpdatedAt(new \DateTime());
            $entityManager->persist($document);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_document/new.html.twig', [
            'document' => $document,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_document_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Document $document, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $documentFile = $form->get('documentFile')->getData();
            if ($documentFile) {
                // Delete old file if exists
                $oldFilename = $document->getFilename();
                if ($oldFilename) {
                    $oldFilePath = $this->getParameter('kernel.project_dir').'/public/'.$oldFilename;
                    if (file_exists($oldFilePath) && is_file($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $originalFilename = pathinfo($documentFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$documentFile->guessExtension();

                try {
                    $documentFile->move(
                        $this->getParameter('kernel.project_dir').'/public/uploads/documents',
                        $newFilename
                    );
                    $document->setFilename('uploads/documents/' . $newFilename);
                } catch (FileException $e) {
                    // Handle exception
                }
            }
            
            $document->setUpdatedAt(new \DateTime());
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_document/edit.html.twig', [
            'document' => $document,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_document_delete', methods: ['POST'])]
    public function delete(Request $request, Document $document, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$document->getId(), $request->getPayload()->getString('_token'))) {
            $filename = $document->getFilename();
            if ($filename) {
                $filePath = $this->getParameter('kernel.project_dir').'/public/'.$filename;
                if (file_exists($filePath) && is_file($filePath)) {
                    unlink($filePath);
                }
            }
            $entityManager->remove($document);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_document_index', [], Response::HTTP_SEE_OTHER);
    }
}
