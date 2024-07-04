<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('dateEmbauche', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('ville', TextType::class)
            ->add('entreprise', EntityType::class, [ // on choisit le type EntityType::class, on va avoir besoin de spécifier des choses dans un tableau d'arguments
                'class' => Entreprise::class, // on inqique qu' Entreprise::class est notre classe (qu'il faut penser à importer) NOTE ceci peut être le cas car on a mis un tostring qui renvoie la raisonSociale
                'choice_label' => 'raisonSociale', // on choisit sur quel propriété d'Entreprise on effectue la sélection. 
            ])
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employe::class,
        ]);
    }
}
