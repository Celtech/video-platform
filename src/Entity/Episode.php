<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EpisodeRepository")
 */
class Episode
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Series", inversedBy="episodes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $series;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Video", mappedBy="episode_id")
     */
    private $videos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EpisodeComment", mappedBy="episode")
     */
    private $episodeComments;

    public function __construct()
    {
        $this->videos = new ArrayCollection();
        $this->episodeComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeries(): ?Series
    {
        return $this->series;
    }

    public function setSeries(?Series $series): self
    {
        $this->series = $series;

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

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeInterface $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setEpisodeId($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->contains($video)) {
            $this->videos->removeElement($video);
            // set the owning side to null (unless already changed)
            if ($video->getEpisodeId() === $this) {
                $video->setEpisodeId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EpisodeComment[]
     */
    public function getEpisodeComments(): Collection
    {
        return $this->episodeComments;
    }

    public function addEpisodeComment(EpisodeComment $episodeComment): self
    {
        if (!$this->episodeComments->contains($episodeComment)) {
            $this->episodeComments[] = $episodeComment;
            $episodeComment->setEpisode($this);
        }

        return $this;
    }

    public function removeEpisodeComment(EpisodeComment $episodeComment): self
    {
        if ($this->episodeComments->contains($episodeComment)) {
            $this->episodeComments->removeElement($episodeComment);
            // set the owning side to null (unless already changed)
            if ($episodeComment->getEpisode() === $this) {
                $episodeComment->setEpisode(null);
            }
        }

        return $this;
    }
}
