<?php

namespace App\Service\Image;

use App\Entity\Image;

interface RemoteImageServiceInterface
{
    public function saveRemoteImage(string $url): ?Image;
    public function isRemoteImageAvailable(string $url): bool;
}