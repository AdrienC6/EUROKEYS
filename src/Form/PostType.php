<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('location', TextType::class, [
                'label' => 'Localisation (optionnel)'
            ])
            ->add('country', TextType::class, [
                'label' => 'Pays (optionnel)'
            ])
            ->add('createdAt', DateType::class, [
                'label' => 'Date (optionnel)'
            ])
            ->add('imageFile', VichImageType::class, [
                'label'=>'Image (JPG ou PNG)',
                'required' => true,
                'allow_delete' => false,
                'delete_label' => 'Supprimer l\'image',
                'download_uri' => false,
                'imagine_pattern' => 'squared_thumbnail_small',
                            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
