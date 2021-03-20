<?php

namespace App\DataFixtures;

use App\Entity\Announcement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnnouncementFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
         $announcement = (new Announcement())
             ->setUser($this->getReference(AppFixtures::MY_USER))
             ->setCategory('Motoryzacja')
             ->setSubcategory('Oleje')
             ->setName('Olej silnikowy')
             ->setStatus('active')
            ->setDescription('Testowy opis produktu ogłoszenia.');
         $manager->persist($announcement);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AppFixtures::class,
        ];
    }
}
