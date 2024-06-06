<?php

namespace App\Service;

use Exception;
use App\Entity\Image;
use App\Entity\Vehicule;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService
{
    private EntityManagerInterface  $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager    = $entityManager;
    }
    
    public function uploadedFileToImage(UploadedFile $file, Vehicule $vehicule) : void
    {
        $fileName = $vehicule->getNumberplate() . '_' . time() . '.' . $file->guessExtension();

        $image = new Image();
        $image->setUrl('/uploads/images/' . $fileName);
        $image->setVehicule($vehicule);

        $file->move(
            'uploads/images',
            $fileName
        );
        
        $this->entityManager->persist($image);
        $this->entityManager->flush();
    }

}