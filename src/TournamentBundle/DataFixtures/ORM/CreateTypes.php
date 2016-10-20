<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TournamentBundle\Entity\Type;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $typeFFA = new Type();

        $typeFFA->setCode(10);
        $typeFFA->setName("FFA");
        $manager->persist($typeFFA);


        $typeFFAGame = new Type();

        $typeFFAGame->setCode(20);
        $typeFFAGame->setName("FFA_GAME");
        $manager->persist($typeFFAGame);

        $manager->flush();
    }
}