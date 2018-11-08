<?php
/**
 * Created by PhpStorm.
 * User: benmacha
 * Date: 11/8/18
 * Time: 12:35
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

    /**
     * @var \AppBundle\Repository\UserRepository|\Doctrine\Common\Persistence\ObjectRepository
     */
    private $repo;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->repo = $em->getRepository(User::class);
        $this->encoder = $encoder;
    }

    /**
     * @return User[]|array
     */
    public function getAll(){
        return $this->repo->findAll();
    }

    /**
     * @param User $user
     * @return User
     */
    public function add(User $user)
    {
        $password = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($password);
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}