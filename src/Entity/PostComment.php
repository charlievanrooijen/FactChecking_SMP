<?php

namespace App\Entity;

use App\Repository\PostCommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostCommentRepository::class)]
class PostComment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'postComments')]
    private ?Post $ActionTarget = null;

    #[ORM\Column(length: 255)]
    private ?string $text = null;

    #[ORM\ManyToOne(inversedBy: 'postComments')]
    private ?Account $Commenter = null;

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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCommenter(): ?Account
    {
        return $this->Commenter;
    }

    public function setCommenter(?Account $Commenter): self
    {
        $this->Commenter = $Commenter;

        return $this;
    }
}
