<?php

namespace App\Form;

use App\Entity\UserMonobankToken;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserMonobankTokenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('token', TextType::class, [
                'row_attr' => [
                    'class' => 'form-group'
                ],
                'label' => 'Токен',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control-lg',
                    'placeholder' => 'Введите токен монобанка'
                ],
            ])
            ->add('save', SubmitType::class, [
                'row_attr' => [
                    'class' => 'd-grid'
                ],
                'label' => 'Сохранить',
                'attr' => [
                    'class' => 'btn btn-primary btn-lg text-uppercase text-white me-2'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserMonobankToken::class,
        ]);
    }
}
