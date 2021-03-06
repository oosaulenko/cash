<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
                    'class' => 'form-group mb-4'
                ],
              'label' => 'Название',
              'label_attr' => [
                  'class' => 'form-label',
              ],
              'attr' => [
                  'class' => 'form-control-lg',
                  'placeholder' => 'Введите название категории'
              ]
            ])
            ->add('keywords', TextareaType::class, [
                'row_attr' => [
                    'class' => 'form-group mb-4'
                ],
                'label' => 'Ключи категории',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control-lg field-keywords',
                    'placeholder' => 'Введите через запятую ключи'
                ]
            ])
            ->add('mcc', TextareaType::class, [
                'row_attr' => [
                    'class' => 'form-group mb-4'
                ],
                'label' => 'MCC',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control-lg field-mcc',
                    'placeholder' => 'Введите через запятую MCC-ключи'
                ]
            ])
            ->add('icon', TextType::class, [
                'row_attr' => [
                    'class' => 'form-group mb-4'
                ],
                'label' => 'Иконка',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control-lg',
                    'placeholder' => 'Вставьте ключ иконки'
                ]
            ])
            ->add('priority', NumberType::class, [
                'row_attr' => [
                    'class' => 'form-group mb-4'
                ],
                'label' => 'Приоритет',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control-lg',
                ]
            ])
            ->add('color', TextType::class, [
                'row_attr' => [
                    'class' => 'form-group mb-4'
                ],
                'label' => 'Цвет категории',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control-lg',
                    'placeholder' => 'Цвет категории'
                ]
            ])
            ->add('isDefault', CheckboxType::class, [
                'row_attr' => [
                    'class' => 'form-group mb-4 form-switch'
                ],
                'label'    => 'По умолчанию',
                'required' => false,
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
            ->add('delete', SubmitType::class, [
                'row_attr' => [
                    'class' => 'w-auto d-inline-block'
                ],
                'label' => 'Удалить',
                'attr' => [
                    'class' => 'btn btn-danger text-uppercase text-white btn-lg'
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
