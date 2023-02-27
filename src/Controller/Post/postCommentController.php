<?php

namespace App\Controller\Post;

use App\Entity\Account;
use App\Entity\Post;
use App\Entity\PostComment;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class postCommentController extends AbstractController
{
    #[Route('/comment/interface', name: 'comment_interface', methods: ['GET','POST'])]
    public function __invoke(Request $request)
    {
        return $this->render('blocks/commentinterface.html.twig', [
            'post' => $request->query->get('post'),
            'account' => $request->query->get('account'),
        ]);
    }

    #[Route('/new/comment/{postId}/{accountId}', name: 'comment_new', methods: ['GET','POST'])]
    public function setComment($postId, $accountId, Request $request, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();

        $accountRepo = $em->getRepository(Account::class);
        $PostRepo = $em->getRepository(Post::class);

        $postcomment = new PostComment();
        $postcomment->setCommenter($accountRepo->findOneBy(['id' => $accountId]));
        $postcomment->setActionTarget($PostRepo->findOneBy(['id' => $postId]));
        $postcomment->setText($request->query->get('text'));

        $em->persist($postcomment);
        $em->flush();
        return $this->redirect($request->headers->get('referer'));
    }
}