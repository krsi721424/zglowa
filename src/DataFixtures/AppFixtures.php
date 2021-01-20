<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public const MY_USER = 'my-user';

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = (new User())
            ->setUsername('kris')
            ->setEmail('kris721424@gmail.com');
        $user->setPassword($this->encoder->encodePassword($user, 'pass_1234'));
        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::MY_USER, $user);
    }
}
