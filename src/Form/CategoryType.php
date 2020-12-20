<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'row_attr' => [
                    'class' => 'form-group'
                ],
              'label' => 'Название',
              'attr' => [
                  'class' => 'form-control',
                  'placeholder' => 'Введите название категории'
              ]
            ])
            ->add('keywords', TextareaType::class, [
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Ключи категории',
                'attr' => [
                    'class' => 'form-control field-keywords',
                    'placeholder' => 'Введите через запятую ключи'
                ]
            ])
            ->add('mcc', TextareaType::class, [
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'MCC',
                'attr' => [
                    'class' => 'form-control field-mcc',
                    'placeholder' => 'Введите через запятую MCC-ключи'
                ]
            ])
            ->add('icon', TextType::class, [
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Иконка',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Вставьте ключ иконки'
                ]
            ])
            ->add('priority', NumberType::class, [
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Приоритет',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('save', SubmitType::class, [
                'row_attr' => [
                    'class' => 'w-auto d-inline-block'
                ],
                'label' => 'Сохранить',
                'attr' => [
                    'class' => 'btn btn-primary mr-2'
                ]
            ])
            ->add('delete', SubmitType::class, [
                'row_attr' => [
                    'class' => 'w-auto d-inline-block'
                ],
                'label' => 'Удалить',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
