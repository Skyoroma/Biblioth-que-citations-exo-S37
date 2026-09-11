<?php
namespace App\Controller;

use App\Entity\Citation;
use App\Repository\CitationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CitationController extends AbstractController
{
    private CitationRepository $citationRepository;

    public function __construct(CitationRepository $citationRepository)
    {
        $this->citationRepository = $citationRepository;
    }

    #[Route('/citation', name: 'citation_liste')]
    public function index(): Response
    {
        $citations = $this->citationRepository->findAll();

        return $this->render('citation/index.html.twig', [
            'citations' => $citations,
        ]);
    }

    #[Route('/citation/{id}/delete', name: 'app_citation_delete', methods: ['POST'])]
    public function supprimer(Citation $citation, Request $request, EntityManagerInterface $em): Response
    {
        $token = $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete' . $citation->getId(), $token)) {
            $em->remove($citation);
            $em->flush();

            $this->addFlash('success', 'Produit supprimé avec succès.');
        } else {
            $this->addFlash('error', 'Jeton CSRF invalide, suppression annulée.');
        }

        return $this->redirectToRoute('citation_liste');
    }
}