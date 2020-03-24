<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Item;
use App\Form\ItemType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminItemController extends AbstractController
{

    private $repository;
    private $categoryRepository;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Item :: class);
        $this->categoryRepository = $em->getRepository(Category :: class);
    }

    /**
     * @Route("/admin/item", name="admin_item")
     */
    public function index()
    {
        $items = $this->repository->findAll();

        return $this->render('admin/admin_item/index.html.twig', compact('items'));
    }


    /**
     * @Route("/admin/item/create", name="admin.item.new")
     */
    public function new(Request $request)
    {
        
        $item = new Item(); 
        $categories = $this->categoryRepository->findAll();
        //dd($categories);
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($item);
            $this->em->flush();
            return $this->redirectToRoute('admin_item');
        }

        return $this->render('admin/admin_item/new.html.twig', [
            'item' => $item,
            'form' => $form->createView()
        ]);
        
    }

}
