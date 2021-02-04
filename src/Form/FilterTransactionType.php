<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterTransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add('typeIncome', CheckboxType::class, [
                'label' => 'Доходы',
                'required' => false
            ])
            ->add('typeExpense', CheckboxType::class, [
                'label' => 'Расходы',
                'required' => false
            ])
            ->add('sort', ChoiceType::class, [
                'placeholder' => 'Выберите сортировку',
                'row_attr' => [
                    'class' => 'form-group mb-3'
                ],
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'field-select form-select'
                ],
                'choices' => [
                    'По убыванию даты' => 'DESC',
                    'По возрастанию даты' => 'ASC',
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'expanded' => true,
                'multiple' => true,
                'label' => false,
                'attr' => ['class' =>'d-flex flex-wrap'],
                'choice_label' => function ($category) {
                    return $category->getName();
                },
                'choice_attr' => function($choice, $key, $value) {
                    return [
                        'class' => 'form-check-tag',
                        'style' => 'background-color: '.$choice->getColor()
                    ];
                },
            ])
            ->add('dateFrom', TextType::class, [
                'row_attr' => [
                    'class' => 'form-group-date'
                ],
                'mapped' => false,
                'attr' => ['class' => 'form-control-date dark', 'name' => ''],
                'label' => 'От',
                'label_attr' => [
                    'class' => 'form-label text-secondary',
                ]
            ])
            ->add('timeFrom', HiddenType::class, [])
            ->add('dateTo', TextType::class, [
                'row_attr' => [
                    'class' => 'form-group-date'
                ],
                'attr' => ['class' => 'form-control-date dark'],
                'label' => 'До',
                'label_attr' => [
                    'class' => 'form-label text-secondary',
                ]
            ])
            ->add('timeTo', HiddenType::class, [])
            ->add('amountFrom', TextType::class, [
                'attr' => ['class' => 'dark'],
                'label' => false
            ])
            ->add('amountTo', TextType::class, [
                'attr' => ['class' => 'dark'],
                'label' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
