<?php


namespace SistemaAcesso\SchoolBundle\Form\Type;


use SistemaAcesso\SchoolBundle\Entity\Teacher;
use SistemaAcesso\UserBundle\Form\AdminType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeacherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('siape', 'text', array('label' => 'SIAPE', 'required' => false, 'attr' => ['class' => 'numeric']))
        ;

    }

    public function getParent()
    {
        return AdminType::class;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Teacher::class,
            'cascade_validation' => true
        ));
    }
}