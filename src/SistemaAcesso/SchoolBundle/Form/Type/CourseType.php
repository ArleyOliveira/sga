<?php
/**
 * Created by PhpStorm.
 * User: arley
 * Date: 13/11/16
 * Time: 01:54
 */

namespace SistemaAcesso\SchoolBundle\Form\Type;


use SistemaAcesso\SchoolBundle\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Nome',))
            ->add('sigla', 'text', array('label' => 'Sigla',))
            ->add('knowledgeArea', 'text', array('label' => 'Área do Conhecimento',))
            ->add('active', CheckboxType::class, array(
                'label' => 'Ativo?',
                'required' => false,
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Course::class,
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "course";
    }
}