<?php

namespace App\DTO;

class ImageGridDto
{
    public const IMAGE_COUNT_PER_ROW = 4;

    private int $count = 0;
    private float $size = 0;
    private string $measurement = '';

    /**
     * @var string[][]
     */
    private array $imagesPath = [];

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getSize(): float
    {
        return $this->size;
    }

    public function setSize(float $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getMeasurement(): string
    {
        return $this->measurement;
    }

    public function setMeasurement(string $measurement): self
    {
        $this->measurement = $measurement;

        return $this;
    }

    public function getImagesPath(): array
    {
        return $this->imagesPath;
    }

    public function setImagesPath(array $imagesPath): self
    {
        $this->imagesPath = $imagesPath;

        return $this;
    }
}