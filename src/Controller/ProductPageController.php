<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductPageController extends AbstractController
{
    public array $photos = ['mainPagePhoto','photo1','photo2','photo3'];

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
    #[IsGranted('ROLE_MODERATOR')]
    public function productPageAdd(ProductRepository $products,Request $request,SluggerInterface $slugger): Response
    {

        $product = new Product();
        $form = $this->createForm(ProductType::class,$product);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid())
        {

            foreach ($this->photos as $photo)
            {
                // Получения данных конкретного поля
                $oneOfImage = $form->get($photo)->getData();

                if ($oneOfImage)
                {
                    // Получение оригинального имени (только конечного названия)
                    $originalNameImage = pathinfo($oneOfImage->getClientOriginalName(),PATHINFO_FILENAME);

                    // Получение имени без подчеркиваний и пробелов ( Для корректного дальнейшего отображения в HTML)
                    $safeFilename = $slugger->slug($originalNameImage);

                    // Добавление уникального айди и расширения например JPG
                    $newFileName = $safeFilename . '-' . uniqid() . '.' . $oneOfImage->guessExtension() ;

                    if ($photo === 'mainPagePhoto')
                    {
                        $imageDirectory = 'mains_images_directory';
                    }else{
                        $imageDirectory = 'page_images_directory';
                    }

                    // Сохранение фото в папку
                    try{
                        $oneOfImage->move(
                            // Указанный в скобках параметр это директория куда будет отправляться загруженная картинка
                            // находится указанный в скобках ключ в services.yaml
                            $this->getParameter($imageDirectory),
                            $newFileName
                        );
                    } catch (FileException $e){

                    }

                    if ($photo === 'mainPagePhoto')
                    {
                        $product->setMainPagePhoto($newFileName);
                    }elseif ($photo === 'photo1')
                    {
                        $product->setPhoto1($newFileName);
                    }elseif ($photo === 'photo2')
                    {
                        $product->setPhoto2($newFileName);
                    }elseif ($photo === 'photo3'){
                        $product->setPhoto3($newFileName);
                    }

                }
            }

            $product = $form->getData();
            $products->save($product,true);
            $this->addFlash('success','Ваш продукт был добавлен');

            return $this->redirectToRoute('app_main_page');
        }

        return $this->render('pages/add-product.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/products/{product}/edit', name: 'app_product_page_edit')]
    #[IsGranted('ROLE_MODERATOR')]
    public function productPageEdit(Product $product,ProductRepository $products,Request $request,SluggerInterface $slugger): Response
    {

        $form = $this->createForm(ProductType::class,$product);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid())
        {

            foreach ($this->photos as $photo)
            {
                // Получения данных конкретного поля
                $oneOfImage = $form->get($photo)->getData();

                if ($oneOfImage)
                {
                    // Получение оригинального имени (только конечного названия)
                    $originalNameImage = pathinfo($oneOfImage->getClientOriginalName(),PATHINFO_FILENAME);

                    // Получение имени без подчеркиваний и пробелов ( Для корректного дальнейшего отображения в HTML)
                    $safeFilename = $slugger->slug($originalNameImage);

                    // Добавление уникального айди и расширения например JPG
                    $newFileName = $safeFilename . '-' . uniqid() . '.' . $oneOfImage->guessExtension() ;

                    if ($photo === 'mainPagePhoto')
                    {
                        $imageDirectory = 'mains_images_directory';
                    }else{
                        $imageDirectory = 'page_images_directory';
                    }

                    // Сохранение фото в папку
                    try{
                        $oneOfImage->move(
                        // Указанный в скобках параметр это директория куда будет отправляться загруженная картинка
                        // находится указанный в скобках ключ в services.yaml
                            $this->getParameter($imageDirectory),
                            $newFileName
                        );
                    } catch (FileException $e){

                    }

                    if ($photo === 'mainPagePhoto')
                    {
                        $product->setMainPagePhoto($newFileName);
                    }elseif ($photo === 'photo1')
                    {
                        $product->setPhoto1($newFileName);
                    }elseif ($photo === 'photo2')
                    {
                        $product->setPhoto2($newFileName);
                    }elseif ($photo === 'photo3'){
                        $product->setPhoto3($newFileName);
                    }

                }
            }

            $product = $form->getData();
            $products->save($product,true);

            $this->addFlash('success','Ваш продукт был отредактирован');

            return $this->redirectToRoute('app_main_page');
        }

        return $this->render('pages/add-product.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/products/{product}/delete', name: 'app_product_page_delete')]
    #[IsGranted('ROLE_MODERATOR')]
    public function productPageDelete(Product $product,ProductRepository $products,Request $request): Response
    {

        $products->remove($product,true);

        $this->addFlash('success','Ваш продукт был удален');

        return $this->redirectToRoute('app_main_page');
    }




}
