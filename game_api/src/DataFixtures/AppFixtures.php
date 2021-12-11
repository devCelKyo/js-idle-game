<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Item;
use App\Entity\ItemModel;
use App\Entity\Factory;
use App\Entity\FactoryModel;
use App\Entity\Cost;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $model = new FactoryModel();
        $model->setName("Première Factory");
        $model->setIcon("default.png");
        $model->setBaseRate(20);
        $model->setCost(new Cost());
        $manager->persist($model);
        
        $manager->flush();
    }
}
