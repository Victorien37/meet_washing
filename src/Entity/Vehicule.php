<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Carbon\Carbon;

#[ORM\Entity(repositoryClass: VehiculeRepository::class)]
#[ORM\UniqueConstraint(columns: ['numberplate'])]
class Vehicule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 7)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 7, max: 7)]
    private ?string $numberplate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $circulation_date = null;

    #[ORM\ManyToOne(inversedBy: 'vehicules')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?VehiculeType $vehicule_type = null;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'vehicule')]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberplate(): ?string
    {
        return $this->numberplate;
    }

    public function setNumberplate(string $numberplate): static
    {
        $this->numberplate = $numberplate;

        return $this;
    }

    public function getCirculationDate(): ?\DateTimeInterface
    {
        return $this->circulation_date;
    }

    public function setCirculationDate(\DateTimeInterface $circulation_date): static
    {
        $this->circulation_date = $circulation_date;

        return $this;
    }

    public function getVehiculeType(): ?VehiculeType
    {
        return $this->vehicule_type;
    }

    public function setVehiculeType(?VehiculeType $vehicule_type): static
    {
        $this->vehicule_type = $vehicule_type;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setVehicule($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getVehicule() === $this) {
                $image->setVehicule(null);
            }
        }

        return $this;
    }

    public function toArray() : array
    {
        $images = [];
        foreach ($this->getImages() as $image) {
            $images[] = $image->toArray();
        }

        return [
            'id'                => $this->getId(),
            'numberplate'       => $this->getNumberplate(),
            'circulation_date'  => Carbon::parse($this->getCirculationDate())->format('Y-m-d'),
            'vehicule_type'     => $this->getVehiculeType()->toArray(),
            'images'            => $images,
        ];
    }
}
