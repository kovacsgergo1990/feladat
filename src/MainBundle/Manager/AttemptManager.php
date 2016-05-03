<?php

namespace MainBundle\Manager;
use MainBundle\Entity\Client as Client;
use Doctrine\ORM\EntityManager as EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;


class AttemptManager
{
    private $entityManager;
    private $ipAddress;
    private $client;
    private $attemptCount = 0;
    private $attemptLimit = 4;

    public function __construct(EntityManager $em, RequestStack $requestStack)
    {
        $this->entityManager = $em;

        $currentRequest = $requestStack->getCurrentRequest();
        $this->ipAddress = $currentRequest->getClientIp();

        $this->client = $this->entityManager->getRepository('MainBundle:Client')->findOneBy( array('ipaddress' => $this->ipAddress));

        if (!$this->client)
        {
                $this->client = new Client();
                $this->client->setAttempts(0);
                $this->client->setIpaddress($this->ipAddress);
        }
        else
        {
            $this->client->setAttempts($this->client->getAttempts()+1);

        }

        $this->attemptCount = $this->client->getAttempts();

        $em->persist($this->client);
        $em->flush();
    }

    public function isLimitReached()
    {
        return ($this->attemptCount>=$this->attemptLimit)?true:false;
    }

    public function resetState()
    {
        $this->client = $this->entityManager->getRepository('MainBundle:Client')->findOneBy( array('ipaddress' => $this->ipAddress));

        if ($this->client)
        {
            $this->client->setAttempts(0);
            $this->entityManager->persist($this->client);
            $this->entityManager->flush();
        }

    }
}