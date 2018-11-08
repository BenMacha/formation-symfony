<?php
/**
 * Created by PhpStorm.
 * User: benmacha
 * Date: 11/8/18
 * Time: 12:54
 */

namespace AppBundle\Uploader;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;

    /**
     * FileUploader constructor.
     * @param $targetDir
     */
    public function __construct($targetDir)
    {

        $this->targetDir = $targetDir;
    }

    public function uploadUSerPicture(UploadedFile $file, $fileName = null)
    {
        return $this->upload($this->targetDir['user_image'], $file, $fileName);
    }

    public function getUserImage(){
        return $this->targetDir['user_image'];
    }

    /**
     * @param              $targetDir
     * @param UploadedFile $file
     * @param null         $fileName
     *
     * @return null|string
     */
    public function upload($targetDir, UploadedFile $file, $fileName = null)
    {
        $targetDir = $this->targetDir['root_dir'].$targetDir;
        if ($fileName) {
            $fileName = $fileName.'.'.$file->guessExtension();
        } else {
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
        }
        $file->move($targetDir, $fileName);

        return $fileName;
    }
}