<?php
/**
 * Created by PhpStorm.
 * User: benmacha
 * Date: 10/26/18
 * Time: 5:18 PM
 */

namespace AppBundle\Services;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    private $repository;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(User::class);
        $this->encoder = $encoder;
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function add(User $user)
    {
        $password = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($password);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

}