<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        switch ($options['form_type']) {
            case 'student_questioning':
                $builder
                    ->add('text', TextareaType::class, array(
                        'label' => false,
                        'disabled' => true,
                    ))
                    ->add('answers', CollectionType::class, array(
                        'label' => false,
                        'entry_type' => AnswerType::class,
                        'entry_options' => array(
                            'label' => false,
                        ),
                    ));
                break;
            default:
                $builder
                    ->add('text')
                    ->add('categories', EntityType::class, array(
                        'class' => Category::class,
                        'choice_label' => 'longname',
                        'multiple' => true,
                    ))
                    ->add('answers', CollectionType::class, array(
                        'entry_type' => AnswerType::class,
                        'entry_options' => array(
                            'label' => false,
                        ),
                    ));
        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'form_type' => 'student_questioning',            
        ]);
    }
}
