<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class FindRideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('departure', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Départ',
                    'aria-label' => 'Départ',
                    'aria-describedby' => 'basic-addon1',
                ]
            ])
            ->add('destination', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Destination',
                    'aria-label' => 'Destination',
                    'aria-describedby' => 'basic-addon2',
                ]
            ])
            ->add('date', DateType::class, [
                'label' => false,
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => 'Date',
                    'aria-label' => 'Date',
                    'aria-describedby' => 'basic-addon3',
                ]
            ])
            ->add('seats', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nombre de passagers',
                    'aria-label' => 'Nombre de passagers',
                    'aria-describedby' => 'basic-addon4',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Trouver un trajet',
                'attr' => ['class' => 'btn btn-lg bg-primary text-white']
            ]);
    }
}