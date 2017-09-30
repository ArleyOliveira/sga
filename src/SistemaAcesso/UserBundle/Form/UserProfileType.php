<?php
/**
 * Created by PhpStorm.
 * User: arley
 * Date: 30/09/17
 * Time: 09:57
 */

namespace SistemaAcesso\UserBundle\Form;


use FOS\UserBundle\Util\LegacyFormHelper;
use SistemaAcesso\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Nome', 'required' => true))
            ->add('cpf', 'text', array('label' => 'CPF', 'attr' => array('class' => 'cpf-mask cpf', 'data-toogle' => 'tooltip', 'aria-hidden' => true, 'data-placement' => 'top', 'title' => '')))
            ->add('sex', ChoiceType::class, [
                'label' => 'Sexo',
                'choices' => [
                    "M" => "Masculino",
                    "F" => "Feminino"
                ],
                'attr' => ['class'],
                'required' => false,
                'placeholder' => ""
            ])
            ->add('dateBirth', 'date', [
                'label' => 'Data de Nascimento',
                'horizontal_label_class' => '',
                'format' => 'dd/MM/y',
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'class' => 'datepicker'
                ]
            ])

            ->add('phone', 'text', array('label' => 'Telefone','required' => false, 'attr' => array('class' => 'phone-mask')))
            ->add('cellphone', 'text', array('label' => 'Celular','required' => false, 'attr' => array('class' => 'cellphone-mask')))


        ;

    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'cascade_validation' => true
        ));
    }
}