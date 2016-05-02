<?php

namespace MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{

    /**
     * @Route("/", name="main")
     */
    public function mainAction()
    {
        $ac = $this->get('security.authorization_checker');

        if ($ac->isGranted('ROLE_USER') || $ac->isGranted(array('ROLE_ADMIN')) )
        {
            $this->get('attempt_manager')->resetState();
        }

        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {

        $authUtils = $this->get('security.authentication_utils');
        $ac = $this->get('security.authorization_checker');

        if (!$ac->isGranted('ROLE_USER') || !$ac->isGranted(array('ROLE_ADMIN')) )
        {
            $this->get('attempt_manager');
        }

        $error = $authUtils->getLastAuthenticationError();
        $lastUser = $authUtils->getLastUsername();
        $isLimitReached = $this->get('attempt_manager')->isLimitReached();

        return $this->render('login.html.twig', array ('lastuser'=>$lastUser,'error'=>$error, 'isLimit' => $isLimitReached));
    }



    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction()
    {

        return $this->render('admin.html.twig');
    }
}
