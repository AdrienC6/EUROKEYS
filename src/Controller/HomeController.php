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

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('home/index.html.twig', compact('posts'));
    }

    /**
     * @Route("/concept", name="app_concept")
     */
    public function concept(): Response
    {
        return $this->render('home/concept.html.twig');
    }

    /**
     * @Route("/article/{id<[0-9]+>}", name="app_article")
     */
    public function show(Post $post) : Response
    {
        return $this->render('home/show.html.twig', compact('post'));
    }
}

