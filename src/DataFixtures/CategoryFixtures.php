<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        // POO
        $category = new Category();
        $category->setShortname('POO');
        $category->setLongname('Programmation Orientée Objet');
        $manager->persist($category);

        // PHP
        $category = new Category();
        $category->setShortname('PHP');
        $category->setLongname('Langage PHP');
        $manager->persist($category);

        // Symfony 4
        $category = new Category();
        $category->setShortname('Symf4');
        $category->setLongname('Symfony version 4');
        $manager->persist($category);

        $manager->flush();
    }
}
