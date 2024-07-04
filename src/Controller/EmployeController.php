<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use App\Repository\EmployeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployeController extends AbstractController
{
    #[Route('/employe', name: 'app_employe')]
    
    public function index(EmployeRepository $employeRepository): Response
    {
        
        //$employes = $employeRepository->findAll(); 
        // SELECT * FROM employe ORDER BY nom ASC
        $employes = $employeRepository->findBy([], ['nom' => 'ASC']);
        return $this->render('employe/index.html.twig', [  // méthode qui fait le lien entre le controlleur et la vue, Note : on peut également renvoyer une vue sans transmettre de 'data'
            'employes' => $employes
        ]);
    }

    #[Route('/employe/new', name: 'new_employe')]
    public function new(Request $request): Response // il faut penser à importer la classe request (depuis httpfoundation)
    {
        $employe = new employe();
        
        $form = $this->createForm(EmployeType::class, $employe); // il faut bien penser à importer la classe EmployeType
        
        return $this->render('employe/new.html.twig', [
            'formAddEmploye' => $form,
        ]);
    }

    #[Route('/employe/{id}', name: 'show_employe')]
    public function show(Employe $employe): Response // ici avec cette syntaxe, symfony est capable d'aller récupérer l'id de l'objet employe
    {
        return $this->render('employe/show.html.twig', [  // méthode qui fait le lien entre le controlleur et la vue, Note : on peut également renvoyer une vue sans transmettre de 'data'
            'employe' => $employe
        ]);
    }
}
