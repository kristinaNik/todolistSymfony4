<?php
/**
 * Created by PhpStorm.
 * User: kristina
 * Date: 9/24/18
 * Time: 5:21 PM
 */

namespace App\Form;
use App\Entity\Meetings;
use App\Entity\Users;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class MeetingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class)
            ->add('description', TextareaType::class)
            ->add('start_date', DateTimeType::class, array('widget' => 'single_text',
                'date_format' => 'yyyy-MM-dd  HH:i'))
            ->add('end_date',  DateTimeType::class,array('widget' => 'single_text',
                'date_format' => 'yyyy-MM-dd  HH:i'))
            ->add('users', EntityType::class, array(
                // looks for choices from this entity
                'class' => Users::class,
                'multiple' => true,
                // uses the User.username property as the visible option string
                'choice_label' => 'username',
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Meetings::class,
        ));
    }
}