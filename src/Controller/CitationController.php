<?php
namespace App\Controller;

use App\Repository\CitationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CitationController extends AbstractController
{
    private CitationRepository $citationRepository;

    public function __construct(CitationRepository $citationRepository)
    {
        $this->citationRepository = $citationRepository;
    }

    #[Route('/citation', name: 'citation')]
    public function index(): Response
    {
        return $this->render('citation/index.html.twig', [
            'text' => 'CitationController',
        ]);
    }
}