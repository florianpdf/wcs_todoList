<?php

namespace AppBundle\Services;

use AppBundle\Entity\Picture;

/**
 * Class FileUploader
 *
 * @package AppBundle\Services
 */
class FileUploader{

    /**
     * Target to uploads Directory
     * @var string $targetDir
     */
    private $targetDir;

    /**
     * FileUploader constructor.
     *
     * Define targetDirectory from arguments service declaration
     *
     * @param $targetDir
     */
    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }


    /**
     * Upload file from Picture entity
     *
     * @param \AppBundle\Entity\Picture $picture
     */
    public function upload(Picture $picture)
    {
        $file = $picture->getFile();

        $fileName = uniqid() . '.' . $file->guessExtension();
        $file->move($this->targetDir, $fileName);

        $picture->setName($fileName);
    }

    /**
     * Update file, remove old et create new
     *
     * @param \AppBundle\Entity\Picture $picture
     */
    public function update(Picture $picture){
        $this->remove($picture);
        $this->upload($picture);
    }

    /**
     * Check if file exist and remove if is ok
     *
     * @param \AppBundle\Entity\Picture $picture
     */
    public function remove(Picture $picture){
        $file = $this->targetDir . $picture->getName();
        if (file_exists($file)){
            unlink($this->targetDir . $picture->getName());
        }
    }
}