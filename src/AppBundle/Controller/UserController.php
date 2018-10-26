<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Services\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController
 * @package AppBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @Route("/index")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(UserService $userService)
    {
        $users = $userService->findAll();
        return $this->render('AppBundle:User:index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * @Route("/user/add", name="user_add")
     * @param Request $request
     * @param PasswordEncoderInterface $encoder
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request, UserService $userService)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {

            $user = $userService->add($user);

            $this->redirectToRoute('user_show', array(
                'user' => $user->getId(),
            ));

        }

        return $this->render('AppBundle:User:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/user/{user}", name="user_show")
     * @param Request $request
     * @param User $user
     */
    public function userAction(Request $request, User $user)
    {

        dump($user);
        die;

    }


}