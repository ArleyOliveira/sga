<?php


namespace SistemaAcesso\SchoolBundle\Form\Type;


use Doctrine\ORM\EntityRepository;
use SistemaAcesso\SchoolBundle\Entity\Course;
use SistemaAcesso\SchoolBundle\Entity\Discipline;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DisciplineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Nome',))
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
                'placeholder' => "Selecione um Curso",
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Discipline::class,
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return "discipline";
    }
}