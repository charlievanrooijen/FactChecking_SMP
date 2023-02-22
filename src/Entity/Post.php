<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    private ?string $text = null;

    #[ORM\Column]
    private string $CreatedAt;

    #[ORM\OneToMany(mappedBy: 'ActionTarget', targetEntity: PostAction::class, cascade: ['persist'])]
    private Collection $postActions;

    public function __construct()
    {
        $this->postActions = new ArrayCollection();
    }

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

    public function getCreatedAt(): ?string
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(string $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

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
            $postAction->setActionTarget($this);
        }

        return $this;
    }

    public function removePostAction(PostAction $postAction): self
    {
        if ($this->postActions->removeElement($postAction)) {
            // set the owning side to null (unless already changed)
            if ($postAction->getActionTarget() === $this) {
                $postAction->setActionTarget(null);
            }
        }

        return $this;
    }

    public function getLikeCount(){
        return $this->postActions->count();
    }

    public function findPostActionByAccount($needle) : bool
    {
        foreach($this->postActions->toArray() as $item)
        {
            if ($item->getLikedAccount()->getId() === $needle->getId()){
                return false;
            }
        }

        return true;
    }
}
