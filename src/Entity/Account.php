<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private string $CreatedAt;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Post::class, cascade: ['persist', 'remove'])]
    private Collection $posts;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?array $roles = [];

    #[ORM\OneToMany(mappedBy: 'LikedAccount', targetEntity: PostAction::class)]
    private Collection $postActions;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->postActions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $Id): self
    {
        $this->Id = $Id;

        return $this;
    }


    public function getCreatedAt(): ?string
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(string $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setAuthor($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getAuthor() === $this) {
                $post->setAuthor(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->id . " " . $this->name;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(string $role): self
    {
        $this->roles[] = $role;

        return $this;
    }

    public function isAdmin(): bool
    {
        if($this->roles === null){
            return false;
        }
        return in_array('admin', $this->roles);
    }

    public function eraseCredentials() : self
    {
        $this->roles = [];

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->slug;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, PostAction>
     */
    public function getPostActions(): Collection
    {
        return $this->postActions;
    }

    public function addPostAction(PostAction $postAction): self
    {
        if (!$this->postActions->contains($postAction)) {
            $this->postActions->add($postAction);
            $postAction->setLikedAccount($this);
        }

        return $this;
    }

    public function removePostAction(PostAction $postAction): self
    {
        if ($this->postActions->removeElement($postAction)) {
            // set the owning side to null (unless already changed)
            if ($postAction->getLikedAccount() === $this) {
                $postAction->setLikedAccount(null);
            }
        }

        return $this;
    }
}
