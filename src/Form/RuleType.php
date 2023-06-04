<?php

namespace App\Form;

use App\Entity\Rule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la règle',
                'attr' => ['class' => 'form-control'],
                'required' => false, // rend ce champ non obligatoire
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control'],
                'required' => false, // rend ce champ non obligatoire
            ])
            ->add('rules', EntityType::class, [
                'class' => Rule::class,
                'choice_label' => function (Rule $rule) {
                    return sprintf('%s - %s', $rule->getName(), $rule->getDescription());
                },
                'label' => 'Règles',
                'attr' => ['class' => 'form-control'],
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rule::class,
        ]);
    }
}