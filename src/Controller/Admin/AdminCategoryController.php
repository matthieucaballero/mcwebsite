<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
