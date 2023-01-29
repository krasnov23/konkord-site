<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductPageController extends AbstractController
{
    #[Route('/', name: 'app_product_page')]
    public function index(ProductRepository $products): Response
    {

        return $this->render('mainpage/mainpage.html.twig', [
            'products' => $products->findAll(),
        ]);
    }


}
