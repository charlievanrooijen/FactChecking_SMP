<?php

namespace App\Controller\Post;

use App\Entity\Account;
use App\Entity\Post;
use App\Entity\PostComment;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

class postCommentController extends AbstractController
{
    #[Route('/comment/interface', name: 'comment_interface', methods: ['GET','POST'])]
    public function __invoke(Request $request)
    {
        return $this->render('blocks/commentinterface.html.twig', [
            'post' => $request->query->get('post'),
        ]);
    }

    #[Route('/new/comment/{postId}', name: 'comment_new', methods: ['GET','POST'])]
    public function setComment($postId, RequestStack $requestStack, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();

        $accountRepo = $em->getRepository(Account::class);
        $PostRepo = $em->getRepository(Post::class);

        $postcomment = new PostComment();
        $postcomment->setCommenter($accountRepo->findOneBy(['id' => $requestStack->getSession()->get('account')]));
        $postcomment->setActionTarget($PostRepo->findOneBy(['id' => $postId]));
        $postcomment->setText($requestStack->getCurrentRequest()->query->get('text'));

        $em->persist($postcomment);
        $em->flush();
        return $this->redirect($requestStack->getCurrentRequest()->headers->get('referer'));
    }
}