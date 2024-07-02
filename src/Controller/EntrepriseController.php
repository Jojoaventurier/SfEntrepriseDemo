<?php

namespace App\Controller;

use App\Entity\Entreprise;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(EntityManagerInterface $entityManager): Response //clic droit sur EntityManagerInterface et 'import class'
    {
        $entreprises = $entityManager->getRepository(Entreprise::class)->findAll(); // clic droit sur Entreprise et 'import class'. Sur cette ligne on récuère toutes les entrées de mon tableau 'Entreprise' de la base de donnée
        return $this->render('entreprise/index.html.twig', [  // méthode qui fait le lien entre le controlleur et la vue, Note : on peut également renvoyer une vue sans transmettre de 'data'
            'entreprises' => $entreprises
        ]);
    }

}
