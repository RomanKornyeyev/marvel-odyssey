<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PeliculasFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', TextType::class, [
                'required' => false,
                'label' => 'Nombre',
            ])
            ->add('inicio', IntegerType::class, [
                'required' => false,
                'label' => 'Año desde',
            ])
            ->add('fin', IntegerType::class, [
                'required' => false,
                'label' => 'Año hasta',
            ])
            ->add('orden', ChoiceType::class, [
                'choices'  => [
                    'Ascendente' => 'ASC',
                    'Descendente' => 'DESC',
                ],
                'required' => false,
                'label' => 'Ordenar por año',
                'placeholder' => 'Seleccione una opción'
            ])
            ->add('buscar', SubmitType::class, ['label' => 'Filtrar']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
