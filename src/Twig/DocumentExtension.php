<?php

namespace App\Twig;

use App\Repository\DocumentRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DocumentExtension extends AbstractExtension
{
    private $documentRepository;

    public function __construct(DocumentRepository $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_document_path', [$this, 'getDocumentPath']),
        ];
    }

    public function getDocumentPath(string $identifiant): ?string
    {
        $document = $this->documentRepository->findOneBy(['identifiant' => $identifiant]);
        
        return $document ? $document->getFilename() : null;
    }
}
