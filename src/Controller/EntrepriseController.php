<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')] // le name va servir dans les "path" qu'on va mettre dans nos href sur les pages html pour appeler les différentes méthodes que l'on souhaite
    // public function index(EntityManagerInterface $entityManager): Response
    public function index(EntrepriseRepository $entrepriseRepository): Response //clic droit sur EntrepriseRepository et 'import class'
    {
        // $entreprises = $entityManager->getRepository(Entreprise::class)->findAll();
        // $entreprises = $entrepriseRepository->findAll();
        // SELECT * FROM entreprise ORDER BY raisonSociale ASC
        $entreprises = $entrepriseRepository->findBy([], ["raisonSociale" => "ASC"]); 
        return $this->render('entreprise/index.html.twig', [  // méthode qui fait le lien entre le controlleur et la vue, Note : on peut également renvoyer une vue sans transmettre de 'data'
            'entreprises' => $entreprises
        ]);
    }

    #[Route('/entreprise/{id}', name: 'show_entreprise')]
    public function show(Entreprise $entreprise): Response // ici avec cette syntaxe, symfony est capable d'aller récupérer l'id de l'objet entreprise
    {
        return $this->render('entreprise/show.html.twig', [  // méthode qui fait le lien entre le controlleur et la vue, Note : on peut également renvoyer une vue sans transmettre de 'data'
            'entreprise' => $entreprise
        ]);
    }
    
}

