<?php

/**
 * PHP version 7.* & Symfony 3.4.
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.
 *
 * Baskel.
 *
 * @category   Baskel platform manager
 *
 * @author     Ali Ben Macha       <contact@benmacha.tn>
 * @copyright  Ⓒ 2018 Cubes.TN
 *
 * @see       http://www.cubes.tn
 */

namespace AppBundle\Listener;

use AppBundle\Entity\User;
use AppBundle\Uploader\FileUploader;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadUserPictureListener implements EventSubscriber
{
    private $uploader;

    /**
     * UploadUserPictureListener constructor.
     *
     * @param FileUploader $uploader
     */
    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function getSubscribedEvents()
    {
        return array(
            'postPersist',
            'prePersist',
            'preUpdate',
        );
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        /** @var User $entity */
        $entity = $args->getObject();
        $em = $args->getObjectManager();
        $this->uploadFile($entity);
        $em->flush();
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        /** @var User $entity */
        $entity = $args->getObject();
        $this->uploadFile($entity);
    }

    /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();

        try {
            if ($entity instanceof User) {
                $oldPicture = $args->getOldValue('image');
                $newPicture = $args->getNewValue('image');

                if (null == $newPicture) {
                    $entity->setImage($oldPicture);
                } else {
                    //unlink
                    if ($oldPicture) {
                        @unlink($oldPicture);
                    }
                    $this->uploadFile($entity);
                }
            }
        } catch (\Exception $ex) {
            //dump($ex->getMessage());
        }
    }

    /**
     * @param User|UploadedFile $entity
     */
    private function uploadFile($entity)
    {
        if ($entity instanceof User) {
            $file = $entity->getImage();
            if (!$file instanceof UploadedFile) {
                return null;
            }
            $fileName = $this->uploader->uploadUserPicture($file, md5(uniqid()));
            $entity->setImage($this->uploader->getUserImage().'/'.$fileName);
        }

        return null;
    }
}
