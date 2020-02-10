<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends AbstractController
{
    public function list()
    {
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findAll();

        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('list.html.twig', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    public function show($id)
    {
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($id);

        if (!$post) {
            // cause the 404 page not found to be displayed
            throw $this->createNotFoundException();
        }

        return $this->render('show.html.twig', ['post' => $post]);
    }

    public function show_category($id)
    {
        # code...
    }
} 