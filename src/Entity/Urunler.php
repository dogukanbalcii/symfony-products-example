<?php

namespace App\Entity;

use App\Repository\UrunlerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UrunlerRepository::class)]
class Urunler
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $isim = null;

    #[ORM\Column]
    private ?float $fiyat = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $urunAciklamasi = null;

    #[ORM\ManyToOne(inversedBy: 'kategori')]
    private ?UrunKategori $urunKategori = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsim(): ?string
    {
        return $this->isim;
    }

    public function setIsim(string $isim): static
    {
        $this->isim = $isim;

        return $this;
    }

    public function getFiyat(): ?float
    {
        return $this->fiyat;
    }

    public function setFiyat(float $fiyat): static
    {
        $this->fiyat = $fiyat;

        return $this;
    }

    public function getUrunAciklamasi(): ?string
    {
        return $this->urunAciklamasi;
    }

    public function setUrunAciklamasi(string $urunAciklamasi): static
    {
        $this->urunAciklamasi = $urunAciklamasi;

        return $this;
    }

    public function getUrunKategori(): ?UrunKategori
    {
        return $this->urunKategori;
    }

    public function setUrunKategori(?UrunKategori $urunKategori): static
    {
        $this->urunKategori = $urunKategori;

        return $this;
    }
}
