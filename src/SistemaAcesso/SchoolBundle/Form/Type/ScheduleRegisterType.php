<?php
/**
 * Created by PhpStorm.
 * User: arley
 * Date: 25/03/17
 * Time: 12:15
 */

namespace SistemaAcesso\SchoolBundle\Form\Type;


use Doctrine\ORM\EntityRepository;
use SistemaAcesso\SchoolBundle\Entity\Discipline;
use SistemaAcesso\SchoolBundle\Entity\ScheduleRegister;
use SistemaAcesso\SchoolBundle\Entity\Teacher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduleRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('teacher', EntityType::class, [
                'class' => Teacher::class,
                'label' => 'Professor',
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->where('t.active = :active')
                        ->setParameter("active", 1)
                        ->orderBy('t.name', 'ASC');
                },
                'placeholder' => "Selecione um professor",
            ])

            ->add('discipline', EntityType::class, [
                'class' => Discipline::class,
                'label' => 'Disciplina',
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('d')
                        ->where('d.active = :active')
                        ->setParameter("active", 1)
                        ->orderBy('d.name', 'ASC');
                },
                'placeholder' => "Selecione uma disciplina",
            ])

            ->add(
                'itemsSchedule',
                CollectionType::class,
                [
                    'required' => true,
                    'label' => 'Items',
                    'entry_type' => ItemScheduleType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'allow_extra_fields' => false,
                    'prototype' => true,
                    'by_reference' => true,
                    'delete_empty' => false,
                    'attr' => array(
                        'class' => '',
                    )
                ]
            );
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ScheduleRegister::class,
            'cascade_validation' => true
        ));
    }
}