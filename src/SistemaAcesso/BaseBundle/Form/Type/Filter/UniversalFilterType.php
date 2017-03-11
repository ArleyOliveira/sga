<?php

namespace SistemaAcesso\BaseBundle\Form\Type\Filter;

use Doctrine\ORM\EntityRepository;
use SistemaAcesso\BaseBundle\Entity\Filter\UniversalFilter;
use SistemaAcesso\SchoolBundle\Entity\Course;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UniversalFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Nome', 'required' => false, 'attr' => ['placeholder' => 'Nome']))
            ->add('year', 'text', array('label' => 'Ano', 'attr' => ['class' => 'datepicker-only-year', 'placeholder' => 'Ano'], 'required' => false))
            ->add('email', 'text', array('label' => 'Email', 'required' => false, 'attr' => ['placeholder' => 'E-mail']))
            ->add('knowledgeArea', 'text', array('label' => 'Área do Conhecimento', 'required' => false, 'attr' => ['placeholder' => 'Área do conhecimento']))
            ->add('course', EntityType::class, [
                'class' => Course::class,
                'label' => 'Curso',
                'choice_label' => function (Course $course) {
                    return $course->getName();
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.active = :active')
                        ->setParameter("active", 1)
                        ->orderBy('c.active', 'ASC');
                },
                'placeholder' => "Curso",
                'required' => false
            ])
            ->add('active', CheckboxType::class, array(
                'label' => 'Ativo?',
                'required' => false,
            ))
            ->add('semester', ChoiceType::class, [
                'label' => 'Semestre',
                'choices' => [
                    "1" => "1° Semestre",
                    "2" => "2º Semestre"
                ],
                'placeholder' => "Semestre",
                'required' => false,
            ])
        ;

        $builder->setMethod('GET');
    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => UniversalFilter::class,
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "";
    }
}