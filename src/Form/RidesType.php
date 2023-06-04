<?php

namespace App\Form;

use App\Entity\Ride;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Rule;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\ORM\EntityRepository;

class RidesType extends AbstractType
{
    public function __construct(private Security $security)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();

        $builder
            ->add('departure')
            ->add('destination')
            ->add('seats')
            ->add('price')
            ->add('date', DateTimeType::class, [
                'date_widget' => 'single_text',
                'time_widget' => 'choice',
                'input' => 'datetime',
                'with_seconds' => false,
                'minutes' => range(0, 59, 15),
                'hours' => range(1, 24),
            ])
            ->add('rules', EntityType::class, [
                'class' => Rule::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'name',
                'by_reference' => false,
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('r')
                        ->where('r.author = :user')
                        ->setParameter('user', $user);
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ride::class,
        ]);
    }
}