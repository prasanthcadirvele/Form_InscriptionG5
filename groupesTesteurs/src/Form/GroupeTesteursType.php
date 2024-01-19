<?php

namespace App\Form;

use App\Entity\GroupeTesteurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupeTesteursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('groupTesteurLabel', TextType::class, [
                'label' => 'Group Testeur Label',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('groupTesteurDescription', TextareaType::class, [
                'label' => 'Group Testeur Description',
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GroupeTesteurs::class,
        ]);
    }
}
