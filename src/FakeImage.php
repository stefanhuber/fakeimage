<?php

namespace FakeImage;

use FakeImage\Generators\ImageGenerator;
use FakeImage\Generators\RandomImageGenerator;

class FakeImage
{
    protected int $width = 0;
    protected int $height = 0;
    protected ImageGenerator $generator;
    protected \GdImage $image;

    public static function create($width, $height = 0, ImageGenerator $generator = null): FakeImage
    {
        return new FakeImage(
            $width,
            $height <= 0 ? $width : $height,
            $generator == null ? new RandomImageGenerator() : $generator
        );
    }

    function __construct(int $width, int $height, ImageGenerator $generator)
    {
        $this->width = $width;
        $this->height = $height;
        $this->generator = $generator;
    }

    public function generate(): FakeImage
    {
        $this->image = $this->generator->generate($this->width, $this->height);
        return $this;
    }

    public function save($filename): FakeImage
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if ($this->image) {
            switch ($extension) {
                case "png":
                    imagepng($this->image, $filename);
                    break;
                case "jpg":
                case "jpeg":
                    imagejpeg($this->image, $filename);
                    break;
                case "gif":
                    imagegif($this->image, $filename);
                    break;
            }
            imagedestroy($this->image);
        }

        return $this;
    }
}