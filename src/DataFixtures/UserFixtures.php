<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('matcab');
        $user->setRoles(['ROLE_ADMIN']);
        //$user->setPassword($this->encoder->encodePassword($user, 'demo'));
        $user->setPassword('$2y$12$ZOvA3k.6hNybqQbf/uy.RugB6A1v3xOLwMZTGrFSbso5rnRSuadnG');
        $manager->persist($user);
        $manager->flush();
    }
}
