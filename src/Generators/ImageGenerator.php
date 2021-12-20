<?php

namespace FakeImage\Generators;

interface ImageGenerator
{
    public function generate(int $width, int $height): \GdImage;
}