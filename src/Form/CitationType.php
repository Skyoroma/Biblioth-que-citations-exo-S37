<?php

namespace App\Form;

use App\Entity\Citation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CitationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('texte', TextareaType::class, [
                'empty_data' => '',
                'constraints' => [
                    new Assert\NotBlank(message: 'Le texte de la citation est obligatoire.'),
                ],
            ])
            ->add('auteur', TextType::class, [
                'empty_data' => '',
                'constraints' => [
                    new Assert\NotBlank(message: "L'auteur est obligatoire."),
                ],
            ])
            ->add('source', TextType::class, [
                'required' => false,
            ])
            ->add('categorie', TextType::class, [
                'label' => 'Catégorie',
                'empty_data' => '',
                'constraints' => [
                    new Assert\NotBlank(message: 'La catégorie est obligatoire.'),
                ],
            ])
            ->add('langue', TextType::class, [
                'empty_data' => '',
                'constraints' => [
                    new Assert\NotBlank(message: 'La langue est obligatoire.'),
                ],
            ])
            ->add('popularite', IntegerType::class, [
                'label' => 'Popularité (0 à 5)',
                'attr' => ['min' => 0, 'max' => 5],
                'constraints' => [
                    new Assert\NotBlank(message: 'La popularité est obligatoire.'),
                    new Assert\Range(
                        min: 0,
                        max: 5,
                        notInRangeMessage: 'La popularité doit être comprise entre {{ min }} et {{ max }}.',
                    ),
                ],
            ])
            ->add('favori', CheckboxType::class, [
                'required' => false,
            ])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Citation::class,
        ]);
    }
}