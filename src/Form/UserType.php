<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('email', EmailType::class, array(
                'row_attr' => [
                    'class' => 'mb-4'
                ],
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control-lg'
                ]
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array(
                    'row_attr' => [
                        'class' => 'mb-4'
                    ],
                    'label' => 'Пароль',
                    'label_attr' => [
                        'class' => 'form-label',
                    ],
                    'attr' => [
                        'class' => 'form-control-lg'
                    ]
                ),
                'second_options' => array(
                    'row_attr' => [
                        'class' => 'mb-4'
                    ],
                    'label' => 'Повторите пароль',
                    'label_attr' => [
                        'class' => 'form-label',
                    ],
                    'attr' => [
                        'class' => 'form-control-lg'
                    ]
                ),
            ))
            ->add('save', SubmitType::class, array(
                'row_attr' => [
                    'class' => 'd-grid'
                ],
                'label' => 'Зарегистрироваться',
                'attr' => [
                    'class' => 'btn btn-primary btn-lg text-white'
                ],

            ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
