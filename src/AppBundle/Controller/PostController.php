<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Post controller.
 *
 * @Route("admin/post")
 */
class PostController extends Controller
{
    /**
     * @Route("/list", name="admin_post_list")
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(EntityManagerInterface $em)
    {
        $posts = $em->getRepository(Post::class);
        return $this->render('AppBundle:Post:index.html.twig', array(
            'posts' => $posts,
        ));
    }

    /**
     * @Route("/new", name="admin_post_new")
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Post|null $post
     */

    public function addAction( Request $request, EntityManagerInterface $em, Post $post = null){

        if (!$post)
            $post  = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){

            $em->persist($post);
            $em->flush();

        }

        return $this->render('AppBundle:Post:new.html.twig',array(
            'form' => $form->createView()
        ));

    }

    /**
     * @Route("/show/{post}",name="admin_post_show")
     *
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Post $post){
        return $this->render('AppBundle:Post:show.html.twig',array(
            'post' => $post,
        ));
    }
}
