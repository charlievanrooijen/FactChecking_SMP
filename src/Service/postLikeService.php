<?php

namespace App\Service;

use App\Entity\Post\PostLikes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class postLikeService extends AbstractController
{
    public function addLike($post, $account): PostLikes
    {
        $postLikes = new PostLikes();
        $postLikes->setPost($post);
        $postLikes->setPostLikedBy($account);
        return $postLikes;
    }

    public function removeLike($post, $account, $postLikes): void
    {
        $postLikes->removePostLikedBy($account);
        $postLikes->removePostLikedBy($post);
        $account->addPostLike($postLikes);
        $post->setPostLikes($postLikes);
    }
}
