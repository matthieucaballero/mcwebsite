<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $categoryRepository;
    private $itemRepository;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->categoryRepository = $em->getRepository(Category :: class);
        $this->itemRepository = $em->getRepository(Item :: class);
    }


    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $categories = $this->categoryRepository->findAll();
        $items = $this->itemRepository->findAll();

        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'items' => $items
        ]);
    }
}
