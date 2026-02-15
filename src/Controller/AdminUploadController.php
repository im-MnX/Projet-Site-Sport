<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/admin')]
class AdminUploadController extends AbstractController
{
    #[Route('/upload-editor-image', name: 'app_admin_upload_editor_image', methods: ['POST'])]
    public function uploadImage(Request $request, SluggerInterface $slugger): JsonResponse
    {
        $uploadedFile = $request->files->get('upload');

        if (!$uploadedFile) {
            return new JsonResponse(['error' => ['message' => 'No file uploaded.']], 400);
        }

        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();

        try {
            $uploadedFile->move(
                $this->getParameter('kernel.project_dir').'/public/uploads/editor',
                $newFilename
            );
        } catch (FileException $e) {
            return new JsonResponse(['error' => ['message' => 'Failed to upload image.']], 500);
        }

        return new JsonResponse([
            'uploaded' => true,
            'url' => '/uploads/editor/' . $newFilename
        ]);
    }
}
