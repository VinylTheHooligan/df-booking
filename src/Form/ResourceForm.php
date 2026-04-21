<?php

namespace App\Form;

use App\Entity\Resource;
use App\Entity\ResourceType as EntityResourceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResourceForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la ressource :',
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description :',
            ])
            ->add('location', TextType::class, [
                'label' => 'Adresse :',
                'required' => true,
            ])
            ->add('capacity', NumberType::class, [
                'label' => 'Capacité :',
                'required' => true,
            ])
            ->add('isEnabled', CheckboxType::class, [
                'label' => 'Rendre disponible',
            ])
            ->add('resourceType', EntityType::class, [
                'class' => EntityResourceType::class,
                'choice_label' => 'name',
                'label' => 'Type de ressource :'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Resource::class,
        ]);
    }
}
