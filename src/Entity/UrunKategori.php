<?php

namespace App\Entity;

use App\Repository\UrunKategoriRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UrunKategoriRepository::class)]
class UrunKategori
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Urunler>
     */
    #[ORM\OneToMany(targetEntity: Urunler::class, mappedBy: 'urunKategori')]
    private Collection $kategori;

    #[ORM\Column(length: 255)]
    private ?string $isim = null;

    public function __construct()
    {
        $this->kategori = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Urunler>
     */
    public function getKategori(): Collection
    {
        return $this->kategori;
    }

    public function addKategori(Urunler $kategori): static
    {
        if (!$this->kategori->contains($kategori)) {
            $this->kategori->add($kategori);
            $kategori->setUrunKategori($this);
        }

        return $this;
    }

    public function removeKategori(Urunler $kategori): static
    {
        if ($this->kategori->removeElement($kategori)) {
            // set the owning side to null (unless already changed)
            if ($kategori->getUrunKategori() === $this) {
                $kategori->setUrunKategori(null);
            }
        }

        return $this;
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
}
