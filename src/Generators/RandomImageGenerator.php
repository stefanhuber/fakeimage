<?php

namespace FakeImage\Generators;

class RandomImageGenerator implements ImageGenerator
{
    protected int $cellSize;

    public function __construct(int $cellSize = 5)
    {
        $this->cellSize = $cellSize;
    }

    public function generate(int $width, int $height): \GdImage
    {
        $image = imagecreatetruecolor($width, $height);
        $cellCoordinates = $this->calculateCellCoordinates($this->cellSize, $width, $height);
        foreach ($cellCoordinates as $cellCoordinate) {
            $colorValues = $this->generateRandomColor();
            $color = imagecolorallocate($image, $colorValues[0], $colorValues[1], $colorValues[2]);
            imagefilledrectangle($image, $cellCoordinate[0], $cellCoordinate[1], $cellCoordinate[2], $cellCoordinate[3], $color);
        }
        return $image;
    }

    public function generateRandomColor()
    {
        return [rand(0, 255), rand(0, 255), rand(0, 255)];
    }

    public function calculateCellCoordinates(int $cellSize, int $width, int $height)
    {
        $output = [];

        for ($w = 0; $w < $width; $w += $cellSize) {
            for ($h = 0; $h < $height; $h += $cellSize) {
                $points = [$w, $h];
                $points[] = ($w + $cellSize < $width) ? ($w + $cellSize - 1) : ($width - 1);
                $points[] = ($h + $cellSize < $height) ? ($h + $cellSize - 1) : ($height - 1);
                $output[] = $points;
            }
        }

        return $output;
    }


}