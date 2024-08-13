<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\UrunKategori;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Urunler;


class UrunType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isim', TextType::class, [
                'label' => 'İsim',
            ])
            ->add('urunAciklamasi', TextType::class, [
                'label' => 'Açıklama',
            ])
            ->add('fiyat', TextType::class, [
                'label' => 'Fiyat',
            ])
            ->add('urunKategori', EntityType::class, [
                'class' => UrunKategori::class,
                'choice_label' => 'isim',
                'label' => 'Kategori',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Kaydet',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Urunler::class,
        ]);
    }
}
