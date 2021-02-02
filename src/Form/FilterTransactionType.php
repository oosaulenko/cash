<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                'required' => false
            ])
            ->add('typeExpense', CheckboxType::class, [
                'label' => 'Расходы',
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
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'expanded' => true,
                'multiple' => true,
                'choice_label' => 'name',
                'label' => false,
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
