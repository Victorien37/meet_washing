<?php

namespace App\Controller;

use Exception;
use Carbon\Carbon;
use App\Entity\Vehicule;
use App\Helper\Serializer;
use App\Service\ImageService;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\VehiculeTypeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/vehicule')]
class VehiculeController extends AbstractController
{
    private ImageService            $imageService;
    private VehiculeRepository      $repo;
    private EntityManagerInterface  $entityManager;

    public function __construct(ImageService $imageService, VehiculeRepository $repo, EntityManagerInterface $entityManager)
    {
        $this->imageService     = $imageService;
        $this->repo             = $repo;
        $this->entityManager    = $entityManager;
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request, ValidatorInterface $validator, VehiculeTypeRepository $vehicule_type_repo) : JsonResponse
    {
        $vehicule = new Vehicule();
        $vehicule->setNumberplate(strtoupper($request->request->get('numberplate')));
        $vehicule->setCirculationDate(Carbon::parse($request->request->get('circulation_date')));
        if ($request->request->get('vehicule_type')) {
            $vehicule_type = $vehicule_type_repo->findByCategory($request->request->get('vehicule_type'));
            if (!$vehicule_type) {
                $vehicule_type = $vehicule_type_repo->findByName($request->request->get('vehicule_type'));
            }

            if ($vehicule_type) {
                $vehicule->setVehiculeType($vehicule_type);
            }
        }

        $errors = $validator->validate($vehicule);

        if (count($errors) > 0) {
            $return =  Serializer::error($errors, 'Validation error');
        } else {
            try {
                $this->entityManager->persist($vehicule);
                $this->entityManager->flush();

                if ($request->files->get('images')) {
                    foreach ($request->files->get('images') as $image) {
                        $this->imageService->uploadedFileToImage($image, $vehicule);
                    }
                }
    
                $return =  Serializer::success($vehicule->toArray(), 'Vehicule created', JsonResponse::HTTP_CREATED);
            } catch (Exception $e) {
                $return = Serializer::error('An error occured', $e->getMessage());
            }
        }

        return $return;
    }

    #[Route('/{id}', methods: ['GET'])]
    public function get(mixed $id) : JsonResponse
    {
        $vehicule = $this->repo->find($id);
        if (!$vehicule) {
            $vehicule = $this->repo->findOneBy(['numberplate' => strtoupper($id)]);
        }

        $return = $vehicule ? Serializer::success($vehicule->toArray(), 'Vehicule found') : Serializer::error('Vehicule not found', [], JsonResponse::HTTP_NOT_FOUND);

        return $return;
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(Request $request, mixed $id): JsonResponse
    {
        $vehicule = $this->repo->find($id);
        if (!$vehicule) {
            $vehicule = $this->repo->findOneBy(['numberplate' => strtoupper($id)]);
        }

        if ($vehicule) {
            foreach ($vehicule->getImages() as $image) {
                // delete image file
                if (file_exists($image->getUrl())) {
                    unlink($image->getUrl());
                }
                $this->entityManager->remove($image);
                $this->entityManager->flush();
            }

            if ($request->files->get('images')) {
                foreach ($request->files->get('images') as $image) {
                    $this->imageService->uploadedFileToImage($image, $vehicule);
                }
            }

            $return = Serializer::success($vehicule->toArray(), 'Vehicule updated');
        } else {
            $return = Serializer::error('Vehicule not found', [], JsonResponse::HTTP_NOT_FOUND);
        }

        return $return;
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(mixed $id): JsonResponse
    {
        $vehicule = $this->repo->find($id);
        if (!$vehicule) {
            $vehicule = $this->repo->findOneBy(['numberplate' => strtoupper($id)]);
        }

        if ($vehicule) {
            foreach ($vehicule->getImages() as $image) {
                // delete image file
                if (file_exists($image->getUrl())) {
                    unlink($image->getUrl());
                }
                $this->entityManager->remove($image);
                $this->entityManager->flush();
            }
            $this->entityManager->remove($vehicule);
            $this->entityManager->flush();
    
            $return = Serializer::success([], 'Vehicule deleted', JsonResponse::HTTP_NO_CONTENT);
        } else {
            $return = Serializer::error('Vehicule not found', [], JsonResponse::HTTP_NOT_FOUND);
        }

        return $return;
    }
}
