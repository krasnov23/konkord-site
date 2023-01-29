<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product();
        $product->setTitle('Конкорд, пробное название, второе');
        $product->setPhoto1('брендирование-авто.jpg');
        $product->setDescription1('Второе пробное описание');
        $manager->persist($product);

        $product = new Product();
        $product->setTitle('Конкорд, пробное название, третье');
        $product->setPhoto1('брендирование-авто.jpg');
        $product->setDescription1('Третье пробное описание');
        $manager->persist($product);

        $manager->flush();
    }
}
