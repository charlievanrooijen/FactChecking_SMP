<?php

namespace App\Entity\Post;

use App\Entity\Account;
use App\Repository\PostRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?Account $author = null;

    #[ORM\OneToOne(mappedBy: 'Post', cascade: ['persist', 'remove'])]
    private ?PostLikes $postLikes = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    private ?string $text = null;

    #[ORM\Column]
    private ?string $CreatedAt = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?Account
    {
        return $this->author;
    }

    public function setAuthor(?Account $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

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

    public function getRoles(): array
    {
        // TODO: Implement getRoles() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        // TODO: Implement getUserIdentifier() method.
    }

    public function getCreatedAt(): int
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(string $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getPostLikes(): ?PostLikes
    {
        return $this->postLikes;
    }

    public function setPostLikes(?PostLikes $postLikes): self
    {
        // unset the owning side of the relation if necessary
        if ($postLikes === null && $this->postLikes !== null) {
            $this->postLikes->setPost(null);
        }

        // set the owning side of the relation if necessary
        if ($postLikes !== null && $postLikes->getPost() !== $this) {
            $postLikes->setPost($this);
        }

        $this->postLikes = $postLikes;

        return $this;
    }
}
