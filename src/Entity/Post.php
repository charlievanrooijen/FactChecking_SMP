<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
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

    #[ORM\OneToMany(mappedBy: 'ActionTarget', targetEntity: PostLike::class, cascade: ['persist'])]
    private Collection $postActions;

    #[ORM\OneToMany(mappedBy: 'ActionTarget', targetEntity: PostComment::class, cascade: ['persist'])]
    private Collection $postComments;

    public function __construct()
    {
        $this->postActions = new ArrayCollection();
        $this->postComments = new ArrayCollection();
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
     * @return Collection<int, PostLike>
     */
    public function getPostActions(): Collection
    {
        return $this->postActions;
    }

    public function addPostAction(PostLike $postAction): self
    {
        if (!$this->postActions->contains($postAction)) {
            $this->postActions->add($postAction);
            $postAction->setActionTarget($this);
        }

        return $this;
    }

    public function removePostAction(PostLike $postAction): self
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

    /**
     * @return Collection<int, PostComment>
     */
    public function getPostComments(): Collection
    {
        return $this->postComments;
    }

    public function addPostComment(PostComment $postComment): self
    {
        if (!$this->postComments->contains($postComment)) {
            $this->postComments->add($postComment);
            $postComment->setActionTarget($this);
        }

        return $this;
    }

    public function removePostComment(PostComment $postComment): self
    {
        if ($this->postComments->removeElement($postComment)) {
            // set the owning side to null (unless already changed)
            if ($postComment->getActionTarget() === $this) {
                $postComment->setActionTarget(null);
            }
        }

        return $this;
    }
}
