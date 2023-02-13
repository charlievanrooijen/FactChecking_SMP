<?php

namespace App\Entity\Post;

use App\Entity\Account;
use App\Repository\Post\PostLikeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostLikeRepository::class)]
class PostLikes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'postLikes', targetEntity: Account::class)]
    private ?Account $PostLikedBy;

    #[ORM\OneToOne(inversedBy: 'postLikes', targetEntity: Post::class, cascade: ['persist', 'remove'])]
    private ?Post $Post = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostLikedBy(): ?Account
    {
        return $this->PostLikedBy;
    }

    public function setPostLikedBy(?Account $PostLikedBy): self
    {
        $this->PostLikedBy = $PostLikedBy;

        return $this;
    }

    public function addPostLikedBy(?Account $account): self
    {
        $this->PostLikedBy = $account;

        return $this;
    }
    public function removePostLikedBy(?Account $user): self
    {
        $accountList = $this->PostLikedBy;
        foreach ($accountList as $account){
            if($account === $user){
                unset($accountList[$user]);
            }
        }
        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->Post;
    }

    public function setPost(?Post $Post): self
    {
        $this->Post = $Post;

        return $this;
    }
}
