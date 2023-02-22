<?php

namespace App\Entity;

use App\Repository\PostActionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostActionRepository::class)]
class PostAction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'postActions')]
    private ?Post $ActionTarget;

    #[ORM\ManyToOne(inversedBy: 'postActions')]
    private ?Account $LikedAccount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActionTarget(): ?Post
    {
        return $this->ActionTarget;
    }

    public function setActionTarget(?Post $ActionTarget): self
    {
        $this->ActionTarget = $ActionTarget;

        return $this;
    }

    public function getLikedAccount(): ?Account
    {
        return $this->LikedAccount;
    }

    public function setLikedAccount(?Account $LikedAccount): self
    {
        $this->LikedAccount = $LikedAccount;

        return $this;
    }
}
