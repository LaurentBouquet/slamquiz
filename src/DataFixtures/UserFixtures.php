<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('l.bouquet@ndlaprovidence.org'); //azerty
        $user->setRoles(['ROLE_SUPER_ADMIN']);

        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            '$argon2i$v=19$m=65536,t=4,p=1$QlV3V2ptcHNrcU1DcnpKeA$E4APHqYpPFmNuPHMSp6ojyA65eSmRvJ5SkgnE2kNFz8'
        ));

        $manager->persist($user);

        $manager->flush();
    }
}
