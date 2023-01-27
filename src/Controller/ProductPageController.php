<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductPageController extends AbstractController
{
    #[Route('/', name: 'app_product_page')]
    public function index(): Response
    {
        return $this->render('product_page/index.html.twig', [
            'controller_name' => 'ProductPageController',
        ]);
    }

    #[Route('/page', name: 'app_product_pages')]
    public function testPage(): Response
    {
        return new Response('Hi');
    }
}
