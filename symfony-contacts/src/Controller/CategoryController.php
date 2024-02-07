<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        // $category_list = $categoryRepository->findBy([], ['name' => 'ASC']);
        $catequery = $categoryRepository->findAllAlphabeticallyWithContactCount();

        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'category_list' => $catequery,
            'last_search' => '',
        ]);
    }

    #[Route('/category/{id}', name: 'app_category_show')]
    public function show(Category $category): Response
    {
        return $this->render('category/show.html.twig',
            ['category' => $category, 'last_search' => '', 'show_category' => false]);
    }
}
