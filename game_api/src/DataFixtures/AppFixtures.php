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
        $ferModel = new ItemModel();
        $ferModel->setName("Fer");
        $ferModel->setPrice(0);
        $ferModel->setIcon("fer.png");
        $manager->persist($ferModel);

        $orModel = new ItemModel();
        $orModel->setName("Or");
        $orModel->setPrice(0);
        $orModel->setIcon("or.png");
        $manager->persist($orModel);

        $model = new FactoryModel();
        $model->setName("Première Factory");
        $model->setIcon("default.png");
        $model->setBaseRate(20);
        $cost = new Cost();
        $cost->addItem($ferModel);
        $cost->addItem($orModel);
        $cost->setAmounts(array(1, 0));
        $model->setCost($cost);
        $manager->persist($model);

        $model = new FactoryModel();
        $model->setName("Super Factory");
        $model->setIcon("factory2.png");
        $model->setBaseRate(2000);
        $cost = new Cost();
        $cost->addItem($ferModel);
        $cost->addItem($orModel);
        $cost->setAmounts(array(5000, 200));
        $model->setCost($cost);
        $manager->persist($model);

        $model = new FactoryModel();
        $model->setName("Giga Factory nofake");
        $model->setIcon("factory3.png");
        $model->setBaseRate(100000);
        $cost = new Cost();
        $cost->addItem($ferModel);
        $cost->addItem($orModel);
        $cost->setAmounts(array(5000000, 200000));
        $model->setCost($cost);
        $manager->persist($model);
        
        $manager->flush();
    }
}
