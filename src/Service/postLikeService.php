<?php

namespace App\Service;

use App\Entity\Post\PostLikes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\PostRepository;

class postLikeService extends AbstractController
{
    public function addLike($post, $account): array
    {
        $postLikes = new PostLikes();
        $postLikes->setPost($post);
        $postLikes->setPostLikedBy($account);
        $account->addPostLike($postLikes);
        $post->setPostLikes($postLikes);
        return [$post, $account];
    }

    public function removeLike($post, $account, $postLikes): array
    {
        $postLikes->removePostLikedBy($account);
        $postLikes->removePostLikedBy($post);
        $account->addPostLike($postLikes);
        $post->setPostLikes($postLikes);
        return [$post, $account];
    }
}
