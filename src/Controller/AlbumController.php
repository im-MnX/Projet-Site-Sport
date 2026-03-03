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

        if ($idAlbum === null) {
            $album = $albumRepo->findOneBy(['archive' => 0], ['idAlbum' => 'ASC']);
        } else {
            $album = $albumRepo->find($idAlbum);
            if ($album && $album->isArchive()) {
                $album = $albumRepo->findOneBy(['archive' => 0], ['idAlbum' => 'ASC']);
            }
        }

        if (!$album) {
            $album = $albumRepo->findOneBy(['archive' => 0], ['idAlbum' => 'ASC']);
        }

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
