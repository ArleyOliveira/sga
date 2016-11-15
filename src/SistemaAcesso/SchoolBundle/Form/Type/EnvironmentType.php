<?php


namespace SistemaAcesso\SchoolBundle\Form\Type;


use SistemaAcesso\SchoolBundle\Entity\Environment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnvironmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Nome',))
            ->add('identification', 'text', array('label' => 'Identificação do ambiente',))
            ->add('startTime', TimeType::class, array(
                    'label' => 'Início do funcionamento',
                    'attr' => array('class' => 'time'),
                    'choice_translation_domain' => null,
                    'required' => true,
                    'widget' => 'single_text',
                )
            )
            ->add('endTime', TimeType::class, array(
                    'label' => 'Término do funcionamento',
                    'attr' => array('class' => 'time'),
                    'required' => true,
                    'widget' => 'single_text',
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Environment::class,
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "environment";
    }
}