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
use Symfony\Contracts\Translation\TranslatorInterface;

class UrunType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isim', TextType::class, [
                'label' => $this->translator->trans('form.isim'),
            ])
            ->add('urunAciklamasi', TextType::class, [
                'label' => $this->translator->trans('form.urun_aciklamasi'),
            ])
            ->add('fiyat', TextType::class, [
                'label' => $this->translator->trans('form.fiyat'),
            ])
            ->add('urunKategori', EntityType::class, [
                'class' => UrunKategori::class,
                'choice_label' => 'isim',
                'label' => $this->translator->trans('form.kategori'),
            ])
            ->add('save', SubmitType::class, [
                'label' => $this->translator->trans('form.kaydet'),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Urunler::class,
        ]);
    }
}

