<?php
namespace App\Controller;

use App\Entity\Citation;
use App\Form\CitationType;
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

    
    #[Route('/{id}', name: 'citation_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Citation $citation): Response
    {
        return $this->render('citation/show.html.twig', [
            'citation' => $citation,
        ]);
    }

    #[Route('/add', name:'citation_add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $citation = new Citation();

        $form = $this->createForm(
            CitationType::class, 
            $citation
        );

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($citation);
            $entityManager->flush();

                        $this->addFlash(
                'success',
                'Le produit a été ajouté avec succès.'
            );

            return $this->redirectToRoute(
                'citation_show',
                ['id' => $citation->getId()]
            );

        }

        return $this->render('citation/add.html.twig', [
            'form' => $form,
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