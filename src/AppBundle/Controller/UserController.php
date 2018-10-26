<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class UserController
 * @package AppBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @Route("/index")
     */
    public function indexAction()
    {

        return $this->render('AppBundle:User:index.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/user/add", name="user_add")
     */
    public function addAction()
    {

        return $this->render('AppBundle:User:index.html.twig', array(
            // ...
        ));
    }

}
