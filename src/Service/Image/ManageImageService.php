<?php

namespace App\Service\Image;

use App\DTO\ImageGridDto;
use App\Entity\Image;
use App\Repository\ImageRepository;

class ManageImageService
{
    public function __construct(
        private readonly ImageRepository $imageRepository
    ) {
    }

    public function createImage(
        string $mimeType,
        string $localPath
    ): Image {
        return (new Image())
            ->setMimeType($mimeType)
            ->setSize((string) ceil(filesize($localPath) / 1000000))
            ->setLocalPath($localPath);
    }

    public function saveImage(Image $image): Image
    {
        $this->imageRepository->save($image, true);

        return $image;
    }

    public function createImageGrid(): ImageGridDto
    {
        $grid = new ImageGridDto();

        $size = 0;
        $count = 0;
        $imagesPath = [];

        foreach ($this->imageRepository->findAll() as $image) {
            $size += (int)$image->getSize();
            $count++;

            $path = substr($image->getLocalPath(), strpos($image->getLocalPath(), '/img'));
            $imagesPath[ceil($count / ImageGridDto::IMAGE_COUNT_PER_ROW)][] = $path;
        }

        $grid->setSize($size);
        $grid->setMeasurement('Mb');
        $grid->setCount($count);
        $grid->setImagesPath($imagesPath);

        return $grid;
    }
}