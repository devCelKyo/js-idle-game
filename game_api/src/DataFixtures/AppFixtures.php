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

        $iModel = new ItemModel();
        $iModel->setName("Fer");
        $iModel->setPrice(0);
        $iModel->setIcon("fer.png");
        $manager->persist($iModel);

        $iModel = new ItemModel();
        $iModel->setName("Or");
        $iModel->setPrice(0);
        $iModel->setIcon("or.png");
        $manager->persist($iModel);

        $iModel = new ItemModel();
        $iModel->setName("Fer");
        $iModel->setPrice(0);
        $iModel->setIcon("fer.png");
        $manager->persist($iModel);
        
        $manager->flush();
    }
}
