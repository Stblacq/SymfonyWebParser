<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

use App\Entity\Article;

class ArticleFixture extends Fixture
{

    private $faker;

    public function __construct() {

        $this->faker = Factory::create();
        $this->faker->addProvider(new \Faker\Provider\Internet($this->faker));


    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 50; $i++) {
            $manager->persist($this->getArticle());
        }

        $manager->flush();     
    }

    private function getArticle() {
        $article= new Article();
        $article->setTitle($this->faker->sentence(10));
        $article->setDescription($this->faker->sentence(20));
        $article->setPicture($this->faker->imageUrl(640, 480, 'animals', true));
        $article->setDateAdded($this->get_random_date());
        $article->setDateUpdated($this->get_random_date());
        return $article;
    }

    private function get_random_date()
    {
        $randomTimestamp = mt_rand(1262055681,1262055681);
        $randomDate = new \DateTime();
        $randomDate->setTimestamp($randomTimestamp);
        return $randomDate;
    }        

}
