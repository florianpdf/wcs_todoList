<?php

namespace AppBundle\Services;

use AppBundle\Entity\Picture;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }

    public function upload(Picture $picture)
    {
        $fileName = md5(uniqid()).'.'.$picture->getUploadedFile()->guessExtension();

        $picture->getUploadedFile()->move($this->getTargetDir(), $fileName);

        $picture->setName($fileName);
        $picture->setAlt($fileName);
    }

    public function update(Picture $picture){
        $this->remove($picture->getName());
        $this->upload($picture);
    }

    public function remove($fileName){
        $file = $this->targetDir . $fileName;
        if (file_exists($file)){
            unlink($file);
        }
    }


}