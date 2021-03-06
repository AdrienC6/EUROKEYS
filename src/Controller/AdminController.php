<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="app_admin")
     */
    public function adminIndex(PostRepository $postRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $posts = $postRepository->findBy([], ['createdAt' => 'DESC']);
        return $this->render('admin/index.html.twig', compact('posts'));
    }

    /**
     * @Route("/admin/post", name="app_admin_post")
     */
    public function post(Request $request, EntityManagerInterface $em ): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $post = new Post;

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('admin/post.html.twig', ['form'=>$form->createView()]);
    }

    /**
     * @Route("/admin/edit/{id<[0-9]+>}", name="app_admin_edit", methods={"PUT", "GET"})
     */
    public function edit(Request $request, Post $post, EntityManagerInterface $em) : Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(PostType::class, $post, [
            'method' =>'PUT'
        ]);

        $form->handleRequest($request);
        
        if($form->isSubmitted()&&$form->isValid()){
            $em->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/edit/{id<[0-9]+>}", name="app_admin_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Post $post, EntityManagerInterface $em) : Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if ($this->isCsrfTokenValid('post_deletion' . $post->getId(), $request->request->get('csrf_token'))) {
            $em->remove($post);
            $em->flush();
        }
        

        return $this->redirectToRoute('app_admin');
    }
}

