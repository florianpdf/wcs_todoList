<?php

namespace AppBundle\Form;

use AppBundle\Entity\Category;
use AppBundle\Entity\Priority;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'Titre'
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Description de la tache'
            ))
            ->add('status', ChoiceType::class, array(
                'choices' => array(
                    'A faire' => 0,
                    'Fait' => 1
                ),
                'expanded' => true,
                'multiple' => false,
                'data' => 0
            ))
            ->add('dateEnd', DateTimeType::class, array(
                'label' => 'Date de fin'
            ))
            ->add('category', EntityType::class, array(
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Catégorie'
            ))
            ->add('priority', EntityType::class, array(
                'class' => Priority::class,
                'choice_label' => 'type',
                'label' => 'Priorité de la tache'
            ))
            ->add('picture', PictureType::class)

        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Task'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_task';
    }


}
