<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\City;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchAdsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'required' => false
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'required' => false
            ])
            ->add('priceMin', NumberType::class, [
                'required' => false
            ])
            ->add('priceMax', NumberType::class, [
                'required' => false
            ])
            ->add('search', TextType::class, [
                'required' => false
            ])
            ->add('searchAds', null, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
