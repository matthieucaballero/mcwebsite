<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{

    private $repository;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Category :: class);
    }

    /**
     * @Route("/admin/category", name="admin_category")
     */
    public function index()
    {

        $categories = $this->repository->findAll();
        
        return $this->render('admin/admin_category/index.html.twig', compact('categories'));
    }

    /**
     * @Route("/admin/category/create", name="admin.category.new")
     */
    public function new(Request $request)
    {
        
        $category = new Category(); 

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($category);
            $this->em->flush();
            return $this->redirectToRoute('admin_category');
        }

        return $this->render('admin/admin_category/new.html.twig', [
            'category' => $category,
            'form' => $form->createView()
        ]);
        
    }

    /**
     * @Route("/admin/category/{id}", name="admin.category.edit", methods="GET|POST")
     */
    public function edit(Request $request, Category $category )
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Catégorie modifiée' );
            return $this->redirectToRoute('admin_category');
        }

        return $this->render('admin/admin_category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView()
        ]);

    }



}
