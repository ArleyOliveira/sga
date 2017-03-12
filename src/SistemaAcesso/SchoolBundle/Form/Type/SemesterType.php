<?php


namespace SistemaAcesso\SchoolBundle\Form\Type;


use SistemaAcesso\SchoolBundle\Entity\Semester;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SemesterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year', 'text', array('label' => 'Ano', 'attr' => ['class' => 'datepicker-only-year']))
            ->add('semester', ChoiceType::class, [
                'label' => 'Semestre',
                'choices' => [
                    "1" => "1° Semestre",
                    "2" => "2º Semestre"
                ],
                'placeholder' => "Selecione um semestre"
            ])
            ->add('active', CheckboxType::class, array(
                'label' => 'Ativo?',
                'required' => false,
            ))
            ->add('start', 'date', [
                'label' => 'Data de Início',
                'horizontal_label_class' => '',
                'format' => 'dd/MM/y',
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'class' => 'datepicker'
                ]
            ])
            ->add('end', 'date', [
                'label' => 'Data de Término',
                'horizontal_label_class' => '',
                'format' => 'dd/MM/y',
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'class' => 'datepicker'
                ]
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Semester::class,
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "semester";
    }
}