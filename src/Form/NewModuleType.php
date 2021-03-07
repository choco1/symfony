<?php

namespace App\Form;

use App\Entity\Connection;
use App\Entity\Module;
use App\Entity\PowerSupply;
use App\Entity\Sensor;
use App\Entity\TypeModule;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, [
                'label' => 'Veuillez montionner leNom du Module :',
                'attr' => [
                    'placeholder' => "Nom du Module"
                ]
            ])

            ->add('price', MoneyType::class, [
                'label' => 'Veuillez montionner le Prix du Module :',
                'divisor' => 1,
                'attr' => [
                    'placeholder' => "Prix du Module"
                ]
            ])

            ->add('description', TextareaType::class, [
                'label' => 'Veuillez montionner la description du Module :',
                'attr' => [
                    'placeholder' => "Description du Module"
                ]
            ])

            ->add('numberSerie', NumberType::class, [
                'label' => 'Veuillez montionner le N° de série du Module :',
                    'attr' => [
                        'placeholder' => "le N° de série du Module"
                    ]
                ])

            ->add('functionState', ChoiceType::class, [
                'label' => 'Est il fonctionnel ou en panne  ?',
                'choices' => [
                    'No' => false,
                    'Yes' => true,
                ]
            ])

            ->add('image', FileType::class, [
                'mapped' => false,
            ])


            ->add('autonomie', RangeType::class, [
                'label' => 'la durée de fonctionnement de ce Module  ?',
                'attr' => [
                    'min' => 3,
                    'max' => 30
                ]
            ])

            ->add('temperatureModule', null,[
                'label' => 'Veuillez montionner la temperature minimal du Module :',
                'attr' => [
                    'placeholder' => '-Votre choix-']
            ])

            ->add('maxTemperature', NumberType::class, [
                'label' => 'Veuillez montionner la temperature maximal du Module :',
                'attr' => [
                    'placeholder' => "-Votre choix-"
                ]
            ])


            ->add('type', EntityType::class, [
                'label' => 'Veuillez montionner le type du Module :',
                'class' => TypeModule::class,
                'choice_label' => 'type',
                'expanded' => false,
            ])

            ->add('typePower', EntityType::class, [
                'label' => 'Veuillez montionner le type d\'alimentation du Module :',
                'class' => PowerSupply::class,
                'choice_label' => 'type_of_power',
                'expanded' => false,
            ])

            ->add('sensor', EntityType::class, [
                'label' => 'Veuillez montionner les capteurs du Module :',
                'class' => Sensor::class,
                'choice_label' => 'name_sensor',
                'expanded' => false,
                'multiple'  => true,
            ])


            ->add('connection', EntityType::class, [
                'label' => 'Veuillez montionner le type de connexion du Module :',
                'class' => Connection::class,
                'choice_label' => 'type_connex',
                'expanded' => false,
                'multiple'  => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
        ]);
    }
}
