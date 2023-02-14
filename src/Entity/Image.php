<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $localPath;

    //Kb
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private string $size;

    #[ORM\Column(length: 20)]
    private string $mimeType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocalPath(): string
    {
        return $this->localPath;
    }

    public function setLocalPath(string $localPath): self
    {
        $this->localPath = $localPath;

        return $this;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function setMimeType(string $mimeType): self
    {
        $this->mimeType = $mimeType;

        return $this;
    }
}
