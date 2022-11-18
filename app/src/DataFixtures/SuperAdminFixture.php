<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

use App\Entity\User;

class SuperAdminFixture extends Fixture
{


    public function __construct() {

    }

    public function load(ObjectManager $manager): void
    {
        $manager->persist($this->getSuperAdmin());
        $manager->flush();     
    }

    private function getSuperAdmin() {
        $user = new User();
        $user->setPassword('$ymf0ny');
        $user->setEmail('superadmin@test.com');
        return $user;
    }
     

}
