<?php

namespace App\Form;

use App\Entity\UserPrivatToken;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserPrivatTokenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('privat_id', TextType::class, [
                'row_attr' => [
                    'class' => 'form-group mb-4'
                ],
                'label' => 'Privat ID',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control-lg',
                    'placeholder' => 'Введите ваш Privat ID'
                ]
            ])
            ->add('pass', TextType::class, [
                'row_attr' => [
                    'class' => 'form-group mb-4'
                ],
                'label' => 'Пароль',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control-lg',
                    'placeholder' => 'Введите ваш Privat Pass'
                ]
            ])
            ->add('save', SubmitType::class, [
                'row_attr' => [
                    'class' => 'w-auto d-inline-block'
                ],
                'label' => 'Сохранить',
                'attr' => [
                    'class' => 'btn btn-primary btn-lg text-uppercase text-white me-2'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserPrivatToken::class,
        ]);
    }
}
