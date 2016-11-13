<?php

namespace SistemaAcesso\UserBundle\Form;

use FOS\UserBundle\Util\LegacyFormHelper;
use SistemaAcesso\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Nome', 'required' => true))
            ->add('cpf', 'text', array('label' => 'CPF', 'attr' => array('class' => 'cpf-mask cpf', 'data-toogle' => 'tooltip', 'aria-hidden' => true, 'data-placement' => 'top', 'title' => '')))
            ->add('sexy', ChoiceType::class, [
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
                'format' => 'd/M/y',
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'class' => 'datepicker'
                ]
            ])
            ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array('label' => 'Email', 'translation_domain' => 'FOSUserBundle'))
            ->add('username', null, array('label' => 'Usuário', 'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'Senha'),
                'second_options' => array('label' => 'Confirmação da senha'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))

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
            'data_class' => User\Admin::class,
            'cascade_validation' => true
        ));
    }

}