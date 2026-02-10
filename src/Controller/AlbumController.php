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
    #[Route('/album/{idAlbum?}', name: 'album_show')]
    public function show(?int $idAlbum, ManagerRegistry $doctrine): Response
    {
        $albumRepo = $doctrine->getRepository(Album::class);
        $categorieRepo = $doctrine->getRepository(CategorieAlbum::class);

        // If no ID provided or album not found, get the first available album
        if ($idAlbum === null) {
            $album = $albumRepo->findOneBy([], ['idAlbum' => 'ASC']);
        } else {
            $album = $albumRepo->find($idAlbum);
        }

        // If still no album found, get the first one
        if (!$album) {
            $album = $albumRepo->findOneBy([], ['idAlbum' => 'ASC']);
        }

        // If there are no albums at all, show empty state
        if (!$album) {
            return $this->render('album/album.html.twig', [
                'album' => null,
                'photos' => [],
                'categories' => $categorieRepo->findAll(),
                'albumsByCategorie' => [],
            ]);
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
