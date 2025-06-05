<?php

namespace App\Form;

use App\Entity\Job;
use App\Entity\JobApplication;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobApplicationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cover_letter')
            ->add('created_at', null, [
                'widget' => 'single_text',
            ])
            ->add('applicant', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('job', EntityType::class, [
                'class' => Job::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JobApplication::class,
        ]);
    }
}
