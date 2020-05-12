<?php

namespace App\Form;

use App\Entity\Land;
use App\Entity\Poule;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PouleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('land1', EntityType::class, [
                'class' => Land::class,
                'choice_label' => 'naam',
                'placeholder' => 'Kies een land',
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->orderBy('l.naam', 'ASC');
                },
            ])
            ->add('land2', EntityType::class, [
                'class' => Land::class,
                'choice_label' => 'naam',
                'placeholder' => 'Kies een land',
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->orderBy('l.naam', 'ASC');
                },
            ])
            ->add('land3', EntityType::class, [
                'class' => Land::class,
                'choice_label' => 'naam',
                'placeholder' => 'Kies een land',
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->orderBy('l.naam', 'ASC');
                },
            ])
            ->add('land4', EntityType::class, [
                'class' => Land::class,
                'choice_label' => 'naam',
                'placeholder' => 'Kies een land',
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->orderBy('l.naam', 'ASC');
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'landen' => NULL,
            'user' => NULL,
            'data_class' => Poule::class,
        ]);
    }
}
