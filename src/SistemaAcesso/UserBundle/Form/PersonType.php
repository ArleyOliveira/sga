<?php
/**
 * Created by PhpStorm.
 * User: arley
 * Date: 13/11/16
 * Time: 15:23
 */

namespace SistemaAcesso\UserBundle\Form;



use SistemaAcesso\UserBundle\Entity\User\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('expirationDate', 'date', [
                'label' => 'Data de Expiração do Acesso',
                'horizontal_label_class' => '',
                'format' => 'd/M/y',
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'class' => 'datepicker'
                ]
            ])
            ->add('activity', ChoiceType::class, [
                'label' => 'Atividade a ser Realizada',
                'choices' => Person::ACTIVITIES,
                'required' => true,
                'placeholder' => ""
            ])
        ;

    }

    public function getParent()
    {
        return UserType::class;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Person::class,
            'cascade_validation' => true
        ));
    }
}