<?php

namespace App\Form;

use App\Entity\Workout;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('started_at')
            ->add('ended_at')
            ->add('current_question_number')
            ->add('completed')
            ->add('score')
            ->add('quiz')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Workout::class,
        ]);
    }
}
