<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

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

        $months = $this->getDoctrine()
            ->getRepository(Post::class)
            ->getMonthsWithPosts();

        return $this->render('show.html.twig', [
            'post' => $post,
            'months' => $months,
        ]);
    }

    public function show_category($id)
    {   
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);            

        // $posts = $category->getPosts();

        return $this->render('show_category.html.twig', [
            'categories' => $categories,
            'category' => $category,
            // 'posts' => $posts
        ]); 
    }

    public function show_month(Request $request)
    {
        $year = $request->query->get('year');
        $month = $request->query->get('month');
        
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->getPostsForMonth($year, $month);

        $months = $this->getDoctrine()
            ->getRepository(Post::class)
            ->getMonthsWithPosts();

        return $this->render('show_month.html.twig', [
            'posts' => $posts,
            'months' => $months,
            'month' => $month,
            'year' => $year,
        ]);
    }
} 