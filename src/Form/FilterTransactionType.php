<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
//                'data' => [1],
                'required' => false
            ])
            ->add('typeExpense', CheckboxType::class, [
                'label' => 'Расходы',
//                'data' => [1],
                'required' => false
            ])
            ->add('sort', ChoiceType::class, [
                'row_attr' => [
                    'class' => 'form-group mb-3'
                ],
                'label' => false,
                'attr' => [
                    'class' => 'field-select form-select'
                ],
                'choices' => [
                    'По убыванию даты' => 'DESC',
                    'По возрастанию даты' => 'ASC',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}