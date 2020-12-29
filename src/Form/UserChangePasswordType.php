<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'row_attr' => [
                    'class' => 'mb-4'
                ],
                'label' => 'Старый пароль',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control-lg'
                ]
            ])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array(
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Пожалуйста введите пароль',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Ваш пароль должен содержать не менее {{ limit }} символов.',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                    'row_attr' => [
                        'class' => 'mb-4'
                    ],
                    'label' => 'Новый пароль',
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
                    'label' => 'Повторите новый пароль',
                    'label_attr' => [
                        'class' => 'form-label',
                    ],
                    'attr' => [
                        'class' => 'form-control-lg'
                    ]
                ),
                'invalid_message' => 'Поля паролей не совпадают',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Обновить',
                'attr' => [
                    'class' => 'btn btn-primary btn-lg text-white'
                ],

            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
