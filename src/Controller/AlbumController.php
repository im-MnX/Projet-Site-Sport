<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\CategorieAlbum;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AlbumController extends AbstractController
{
    #[Route('/album/{idAlbum?1}', name: 'album_show')]
    public function show(int $idAlbum, ManagerRegistry $doctrine): Response
    {
        $albumRepo = $doctrine->getRepository(Album::class);
        $categorieRepo = $doctrine->getRepository(CategorieAlbum::class);

        $album = $albumRepo->find($idAlbum);
        if (!$album) {
            throw $this->createNotFoundException('Album non trouvé');
        }

        $photos = $album->getPhotos();
        $categories = $categorieRepo->findAll();

        // Albums regroupés par catégorie
        $albumsByCategorie = [];
        foreach ($categories as $categorie) {
            $albumsByCategorie[$categorie->getIdCategorieAlbum()] = $albumRepo->findBy(['idCategorieAlbum' => $categorie]);
        }

        return $this->render('album/album.html.twig', [
            'album' => $album,
            'photos' => $photos,
            'categories' => $categories,
            'albumsByCategorie' => $albumsByCategorie,
        ]);
    }
}
