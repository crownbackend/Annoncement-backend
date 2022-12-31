<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
class Departement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $codeDepartement = null;

    #[ORM\ManyToOne(inversedBy: 'departements')]
    private ?Region $region = null;

    #[ORM\OneToMany(mappedBy: 'departement', targetEntity: City::class)]
    private Collection $citys;

    public function __construct()
    {
        $this->citys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCodeDepartement(): ?string
    {
        return $this->codeDepartement;
    }

    public function setCodeDepartement(string $codeDepartement): self
    {
        $this->codeDepartement = $codeDepartement;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection<int, City>
     */
    public function getCitys(): Collection
    {
        return $this->citys;
    }

    public function addCity(City $city): self
    {
        if (!$this->citys->contains($city)) {
            $this->citys->add($city);
            $city->setDepartement($this);
        }

        return $this;
    }

    public function removeCity(City $city): self
    {
        if ($this->citys->removeElement($city)) {
            // set the owning side to null (unless already changed)
            if ($city->getDepartement() === $this) {
                $city->setDepartement(null);
            }
        }

        return $this;
    }
}
