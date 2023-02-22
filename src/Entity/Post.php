<?php

namespace App\Entity;

use App\Repository\PostRepository;
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

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    private ?string $text = null;

    #[ORM\Column(nullable: true)]
    private ?int $likes = 0;

    #[ORM\Column]
    private string $CreatedAt;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    /** @var array|null array<int>  */
    private ?array $AccountsLiked = [];

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

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(?int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function addLike(): self
    {
        $this->likes++;

        return $this;
    }

    public function removeLike(): self
    {
        $this->likes--;

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

    public function getAccountsLiked()
    {
        return $this->AccountsLiked;
    }

    public function setAccountsLiked($Account): self
    {
        $this->AccountsLiked = $Account;

        return $this;
    }

    public function addAccountIdToLikedList($AccountId): self
    {
        if($this->AccountsLiked === null || $this->AccountsLiked === []){
            $this->AccountsLiked = [$AccountId];
        }else{
            if(!in_array($AccountId, $this->AccountsLiked)){
                $this->AccountsLiked[] = $AccountId;
            }
        }

        return $this;
    }

    public function removeAccountIdFromLikedList($AccountId): self
    {
        if (($key = array_search($AccountId, $this->AccountsLiked)) !== false) {
            unset($this->AccountsLiked[$key]);
        }
        return $this;
    }
}
