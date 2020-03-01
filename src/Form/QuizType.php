<?php

namespace App\Form;

use App\Entity\Quiz;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('summary')
            ->add('current_question_number')
            ->add('active')
            // ->add('created_at')
            // ->add('updated_at')
            ->add('categories', EntityType::class, array(
                'class' => Category::class,
                'choice_label' => 'longname',
                'multiple' => true
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
        ]);
    }
}
