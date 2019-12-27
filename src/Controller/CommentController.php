<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/comments/create/{article}", name="comment_create_form")
     * @param Request $request
     * @param Article $article
     * @return Response
     * @throws \Exception
     */
    public function create(Request $request, Article $article)
    {
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment, [
            'action' => $this->generateUrl('comment_create_form', [
                'article' => $article->getId()
            ]),
            'method' => 'POST'
        ]);
        $form->add('submit', SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $comment = $form->getData();
            $comment->setCreatedAt(new \DateTime('now'));
            $comment->setArticle($article);

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('single_article', [
                'article' => $article->getId(),
            ]);
        }

        return $this->render('comment/form.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
        ]);
    }

    /**
     * @Route("/comments/update/{article}/{comment}", name="comment_update_form")
     * @param Request $request
     * @param Article $article
     * @param Comment $comment
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function update(Request $request, Article $article, Comment $comment)
    {
        $form = $this->createForm(CommentType::class, $comment, [
            'action' => $this->generateUrl('comment_update_form', [
                'comment' => $comment->getId(),
                'article' => $article->getId(),
            ]),
            'method' => 'POST'
        ]);
        $form->add('submit', SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $comment = $form->getData();
            $comment->setUpdatedAt(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('single_article', [
                'article' => $article->getId(),
            ]);
        }

        return $this->render('comment/form.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
        ]);
    }

    /**
     * @Route("/comments/delete/{article}/{comment}", name="comment_delete")
     * @param Article $article
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function delete(Article $article, Comment $comment)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();

        return $this->redirectToRoute('single_article', [
            'article' => $article->getId(),
        ]);
    }
}
