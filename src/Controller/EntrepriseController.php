<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
                            
    
    #[Route('/entreprise/new', name: 'new_entreprise')]
    #[Route('/entreprise/{id}/edit', name: 'edit_entreprise')] // on ajoute une seconde route pour les éditions, on ajoute edit pour ne pas avoir la même route que sur la méthode show()
    public function new_edit(Entreprise $entreprise = null, Request $request, EntityManagerInterface $entityManager): Response // il faut penser à importer la classe request (depuis httpfoundation)
    {
        if(!$entreprise) { // si entreprise n'existe pas
            $entreprise = new Entreprise(); //on créé un nouvel objet entreprise
        }
        // ici on créé le formulaire
        $form = $this->createForm(EntrepriseType::class, $entreprise); // On créé un formulaire à partir d'une EntrepriseType (il faut bien penser à importer la classe EntrepriseType)
        // ici il va falloir préciser le traitement des données (voir processing forms sur la doc symfony)
        $form->handleRequest($request); // on prend en charge la requête demandée
        if ($form->isSubmitted() && $form->isValid()) { // si le formulaire est validé, et si les données sont valides

            $entreprise = $form->getData(); // alors je récupère les données du formulaire
            //persist() et flush() équivalents du prepare et execute en PDO
            $entityManager->persist($entreprise);
            $entityManager->flush(); // que j'insère en BDD

            return $this->redirectToRoute('app_entreprise'); // on effectue une redirection vers la page de la liste des entreprises
        }
        // ici on affiche le formulaire
        return $this->render('entreprise/new.html.twig', [
            'formAddEntreprise' => $form,
            'edit' => $entreprise->getId() // va renvoyer false si il ne trouve pas d'id, sinon il va récupérer l'id de l'entreprise que je souhaite modifier. On va pouvoir utiliser cette variable dans la vue 
        ]);
    }

    #[Route('/entreprise/{id}/delete', name: 'delete_entreprise')]
    public function delete(Entreprise $entreprise, EntityManagerInterface $entityManager) 
    {
        $entityManager->remove($entreprise);
        $entityManager->flush();

        return $this->redirectToRoute('app_entreprise');
    }
    
    #[Route('/entreprise/{id}', name: 'show_entreprise')]
    public function show(Entreprise $entreprise): Response // ici avec cette syntaxe, symfony est capable d'aller récupérer l'id de l'objet entreprise
    {
        return $this->render('entreprise/show.html.twig', [  // méthode qui fait le lien entre le controlleur et la vue, Note : on peut également renvoyer une vue sans transmettre de 'data'
            'entreprise' => $entreprise
        ]);
    }
}

