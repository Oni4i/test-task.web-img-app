<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadedImageUrlFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', UrlType::class, [
                'attr' => [
                    'placeholder' => 'Input your URL here',
                    'class' => 'w-100 form-control'
                ],
                'row_attr' => [
                    'class' => 'col-12',
                ],
                'label' => ' ',
            ])
            ->add('btn', SubmitType::class, [
                'label' => 'GO',
                'attr' => [
                    'class' => 'btn btn-primary w-100'
                ],
                'row_attr' => [
                    'class' => 'col-2 mt-2',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'attr' => [
                    'class' => 'row'
                ]
            ]);
    }
}