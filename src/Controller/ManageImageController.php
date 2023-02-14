<?php

namespace App\Controller;

use App\DTO\UploadedImageUrlDTO;
use App\Form\UploadedImageUrlFormType;
use App\Service\Image\ManageImageService;
use App\Service\Image\RemoteImageServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManageImageController extends AbstractController
{
    public function __construct(
        private readonly RemoteImageServiceInterface $remoteImageService,
        private readonly ManageImageService $imageService
    ) {
    }

    #[Route('/')]
    public function index(): Response
    {
        return $this->render('image/show.html.twig', [
            'grid' => $this->imageService->createImageGrid(),
        ]);
    }

    #[Route('/create')]
    public function create(Request $request): Response
    {
        $form = $this->createForm(UploadedImageUrlFormType::class, new UploadedImageUrlDTO());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedImageUrlDTO $urlDto */
            $urlDto = $form->getData();
            $image = $this->remoteImageService->saveRemoteImage($urlDto->getUrl());
            $this->imageService->saveImage($image);

            $this->addFlash('success', 'The image was created!');
        }

        return $this->render('image/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}