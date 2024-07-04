<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('raisonSociale', TextType::class) // il faut bien penser à importer les classes utilisées, ici TextType ('import class', choisir celui dans component)
            ->add('dateCreation', DateType::class, [ // il faut également importer la classe DateType
                'widget' => 'single_text',
            ])
            ->add('adresse', TextType::class)
            ->add('cp', TextType::class)
            ->add('ville', TextType::class)
            ->add('valider', SubmitType::class) // on ajoute le bouton SubmitType, et on importe également la classe SubmitType, les classes utilisables dans les forms sont accessibles dans la doc symfony. 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
