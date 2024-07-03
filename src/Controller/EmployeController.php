<?php

namespace App\Controller;

use App\Repository\EmployeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployeController extends AbstractController
{
    #[Route('/employe', name: 'app_employe')]
    // public function index(EntityManagerInterface $entityManager): Response
    public function index(EmployeRepository $employeRepository): Response
    {
        
        $employes = $employeRepository->findAll(); 
        return $this->render('employe/index.html.twig', [  // méthode qui fait le lien entre le controlleur et la vue, Note : on peut également renvoyer une vue sans transmettre de 'data'
            'employes' => $employes
        ]);
    }
}
