<?php

namespace App\Service\Image;

use App\Entity\Image;
use Mimey\MimeTypes;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RemoteImageService implements RemoteImageServiceInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly Filesystem $filesystem,
        private readonly KernelInterface $kernel,
        private readonly MimeTypes $mimeTypes,
        private readonly ManageImageService $imageService
    ){
    }

    public function saveRemoteImage(string $url): ?Image
    {
        $response = $this->httpClient->request('GET', $url);

        $mimeType = ($contentType = $response->getHeaders()['content-type'])
            ? $contentType[0]
            : null;
        $content = $response->getContent();

        if (!$mimeType || strpos($mimeType, 'image/') === -1) {
            return null;
        }

        $extension = $this->mimeTypes->getExtension($mimeType);
        $path = $this->generatePath($content, $extension);


        $this->saveImageLocally($content, $path);

        return $this->imageService->createImage(
            $mimeType,
            $path
        );
    }

    public function isRemoteImageAvailable(string $url): bool
    {
        try {
            return $this->httpClient->request('GET', $url)->getStatusCode() === 200;
        } catch (\Throwable) {
            return false;
        }
    }

    private function generatePath(string $content, string $extension): string
    {
        return sprintf(
            '%s/public/img/%s.%s',
            $this->kernel->getProjectDir(),
            md5($content),
            $extension
        );
    }

    private function saveImageLocally(string $content, string $path): void
    {
        $this->filesystem->dumpFile(
            $path,
            $content
        );
    }
}