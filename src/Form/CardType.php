<?php

namespace App\Form;

use App\Entity\Card;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bank', ChoiceType::class, [
                'row_attr' => [
                    'class' => 'form-group mb-3'
                ],
                'label' => 'Банк',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                  'class' => 'field-select form-control-lg'
                ],
                'choices' => [
                    'Приват Банк' => 'privat_bank',
                    'Monobank' => 'monobank'
                ]
            ])
            ->add('name', TextType::class, [
                'row_attr' => [
                    'class' => 'form-group mb-3'
                ],
                'label' => 'Название карты',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control-lg',
                    'placeholder' => 'Название карты для отображения в системе'
                ]
            ])
            ->add('number_card', TextType::class, [
                'row_attr' => [
                    'class' => 'form-group mb-3'
                ],
                'label' => 'Номер карты',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control-lg',
                    'placeholder' => ''
                ],
                'required' => false
            ])
            ->add('currency', ChoiceType::class, [
                'row_attr' => [
                    'class' => 'form-group mb-3'
                ],
                'label' => 'Валюта',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'field-select form-control-lg'
                ],
                'choices' => [
                    'Гривна' => 'UAH',
                    'Доллар' => 'USD',
                    'Евро' => 'EAH'
                ]
            ])
            ->add('save', SubmitType::class, [
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Добавить',
                'attr' => [
                    'class' => 'btn btn-primary btn-lg text-white'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
        ]);
    }
}
