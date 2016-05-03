<?php

namespace MainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MainBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface as CAIinterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, CAIinterface
{
    private $container;

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        //USEREK LÉTREHOZÁSA
        //az összes user jelszava: 12341234

        //Admin
        $user = new User();
        $user->setUsername('Admin');
        $user->setPassword('$2a$06$1pEYGCjRbztWbNUY4izEo.7pWkA5VEpl0tXnsI2DgKmHeGlvi0WUG');
        $user->setRoles('a:1:{i:0;s:10:"ROLE_ADMIN";}');

        //Taralomszerk+Bejelentkezett felhasznalo
        $user2 = new User();
        $user2->setUsername('User 1');
        $user2->setPassword('$2a$06$1pEYGCjRbztWbNUY4izEo.7pWkA5VEpl0tXnsI2DgKmHeGlvi0WUG');
        $user2->setRoles('a:2:{i:0;s:9:"ROLE_USER";i:1;s:11:"ROLE_EDITOR";}');

        //Tartalomszerk
        $user3 = new User();
        $user3->setUsername('User 2');
        $user3->setPassword('$2a$06$1pEYGCjRbztWbNUY4izEo.7pWkA5VEpl0tXnsI2DgKmHeGlvi0WUG');
        $user3->setRoles('a:1:{i:0;s:11:"ROLE_EDITOR";}');

        //Bejelentkezett felhasznalo
        $user4 = new User();
        $user4->setUsername('User 3');
        $user4->setPassword('$2a$06$1pEYGCjRbztWbNUY4izEo.7pWkA5VEpl0tXnsI2DgKmHeGlvi0WUG');
        $user4->setRoles('a:1:{i:0;s:9:"ROLE_USER";}');

        $manager->persist($user);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($user4);

        $manager->flush();

        //SESSION STORAGE LÉTREHOZÁSA

        $em = $this->container->get('doctrine')->getEntityManager('default');

        $query = $em->getConnection()->prepare('CREATE TABLE IF NOT EXISTS `sessions` (
                          `sess_id` VARBINARY(128) NOT NULL PRIMARY KEY,
                          `sess_data` BLOB NOT NULL,
                          `sess_time` INTEGER UNSIGNED NOT NULL,
                          `sess_lifetime` MEDIUMINT NOT NULL
                        ) COLLATE utf8_bin, ENGINE = InnoDB;');
        $query->execute();

    }

}

