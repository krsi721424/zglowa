<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
         $product = (new Product())
             ->setUser($this->getReference(AppFixtures::MY_USER))
             ->setCategory('Motoryzacja')
             ->setSubcategory('Oleje')
             ->setName('Olej silnikowy')
             ->setStatus('active');
         $manager->persist($product);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AppFixtures::class,
        ];
    }
}
