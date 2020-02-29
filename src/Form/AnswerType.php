<?php

namespace App\Form;

use App\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        switch ($options['form_type']) {
            case 'student_questioning':
                $builder
                    ->add('workout_correct_given', CheckboxType::class, array(
                        'label' => false,
                        'required' => false,
                    ))
                    ->add('text', TextType::class,  array(                    
                        'label' => false,
                        'disabled' => true,                        
                    ));
                break;
            default:
                $builder
                    ->add('text', TextareaType::class, array(
                        'label' => false,
                    ))
                    ->add('correct');
                break;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Answer::class,
            'form_type' => 'student_questioning',            
        ]);
    }
}
