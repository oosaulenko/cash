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
                    'class' => 'form-group'
                ],
                'label' => 'Банк',
                'attr' => [
                  'class' => 'field-select'
                ],
                'choices' => [
                    'Приват Банк' => 'privat_bank',
                    'Monobank' => 'monobank'
                ]
            ])
            ->add('name', TextType::class, [
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Название карты',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Название карты для отображения в системе'
                ]
            ])
            ->add('number_card', TextType::class, [
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Номер карты',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => ''
                ],
                'required' => false
            ])
            ->add('currency', ChoiceType::class, [
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Валюта',
                'attr' => [
                    'class' => 'field-select'
                ],
                'choices' => [
                    'Гривна' => 'UAH',
                    'Доллар' => 'USD',
                    'Евро' => 'EAH'
                ]
            ])
            ->add('key_card', TextType::class, [
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Ключ карты',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => ''
                ],
                'required' => false
            ])
            ->add('save', SubmitType::class, [
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Добавить',
                'attr' => [
                    'class' => 'btn btn-primary btn-block'
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
