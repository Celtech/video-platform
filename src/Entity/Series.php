<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SeriesRepository")
 * @ORM\Table(indexes={@ORM\Index(columns={"title"}, flags={"fulltext"})})
 */
class Series
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Studio", inversedBy="series")
     * @ORM\JoinColumn(nullable=false)
     */
    private $studio;

    /**
     * @Groups({"elastica"})
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cover_art;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deleted_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Episode", mappedBy="series")
     */
    private $episodes;

    public function __construct()
    {
        $this->episodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudio(): ?Studio
    {
        return $this->studio;
    }

    public function setStudio(?Studio $studio): self
    {
        $this->studio = $studio;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCoverArt(): ?string
    {
        return $this->cover_art;
    }

    public function setCoverArt(string $cover_art): self
    {
        $this->cover_art = $cover_art;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(\DateTimeInterface $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    /**
     * @return Collection|Episode[]
     */
    public function getEpisodes(): Collection
    {
        return $this->episodes;
    }

    public function addEpisode(Episode $episode): self
    {
        if (!$this->episodes->contains($episode)) {
            $this->episodes[] = $episode;
            $episode->setSeries($this);
        }

        return $this;
    }

    public function removeEpisode(Episode $episode): self
    {
        if ($this->episodes->contains($episode)) {
            $this->episodes->removeElement($episode);
            // set the owning side to null (unless already changed)
            if ($episode->getSeries() === $this) {
                $episode->setSeries(null);
            }
        }

        return $this;
    }
}
