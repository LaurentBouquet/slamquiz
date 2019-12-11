<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text')
            // ->add('created_at')
            // ->add('updated_at')
            //->add('categories')
        ;

        $builder->add('categories', EntityType::class, array(
            'class' => Category::class,
            'choice_label' => 'longname',
            'multiple' => true
        ));

        $builder->add('answers', CollectionType::class, array(
            'entry_type' => AnswerType::class,
            'entry_options' => array(
                'label' => false,
            )
        ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
