<?php

namespace MainBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_clients")
 */
class Client
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $ipaddress;

    /**
     * @ORM\Column(type="integer")
     */
    private $attempts;

    public function setIpaddress($ipaddress)
    {
        $this->ipaddress = $ipaddress;
    }

    public function setAttempts($attempts)
    {
        $this->attempts = $attempts;
    }

    public function getAttempts()
    {
        return $this->attempts;
    }
}