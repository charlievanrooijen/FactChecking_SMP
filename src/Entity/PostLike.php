<?php

namespace App\Entity;

use App\Repository\PostLikeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostLikeRepository::class)]
class PostLike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?Account $LikedBy = null;

    #[ORM\ManyToOne]
    private ?Post $PostTarget = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLikedBy(): ?Account
    {
        return $this->LikedBy;
    }

    public function setLikedBy(?Account $LikedBy): self
    {
        $this->LikedBy = $LikedBy;

        return $this;
    }

    public function getPostTarget(): ?Post
    {
        return $this->PostTarget;
    }

    public function setPostTarget(?Post $PostTarget): self
    {
        $this->PostTarget = $PostTarget;

        return $this;
    }
}
