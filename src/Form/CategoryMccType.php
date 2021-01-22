<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\CategoryMcc;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryMccType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'row_attr' => [
                    'class' => 'form-group mb-3'
                ],
                'label' => 'Название',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control-lg',
                ]
            ])
            ->add('code', TextType::class, [
                'row_attr' => [
                    'class' => 'form-group mb-3'
                ],
                'label' => 'Код',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control-lg',
                    'data-mask' => '0000',
                ]
            ])
            ->add('category', EntityType::class, [
                'row_attr' => [
                    'class' => 'form-group mb-3'
                ],
                'label' => 'Категория',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'field-select form-control-lg form-select form-select-lg'
                ],
                'class' => Category::class,
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CategoryMcc::class,
        ]);
    }
}
