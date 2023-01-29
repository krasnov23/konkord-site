<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductPageController extends AbstractController
{
    #[Route('/', name: 'app_main_page')]
    public function index(ProductRepository $products): Response
    {

        return $this->render('pages/mainpage.html.twig', [
            'products' => $products->findAll(),
        ]);
    }

    #[Route('/products/{product}', name: 'app_product_page')]
    public function productPage(Product $product): Response
    {

        return $this->render('productpage/index.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/products/add', name: 'app_product_page_add',priority: 2)]
    public function productPageAdd(Product $product): Response
    {

        return $this->render('', [
            'product' => $product,
        ]);
    }

    #[Route('/products/{product}/edit', name: 'app_product_page_edit')]
    public function productPageEdit(Product $product): Response
    {

        return $this->render('pages/productpage.html.twig', [
            'product' => $product,
        ]);
    }




}
