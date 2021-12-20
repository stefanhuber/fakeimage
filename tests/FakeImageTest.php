<?php

use PHPUnit\Framework\TestCase;
use FakeImage\FakeImage;
use FakeImage\Generators\RandomImageGenerator;

final class FakeImageTest extends TestCase
{

    protected function setUp(): void
    {
        if (!is_dir(__DIR__ . "/../.data")) {
            mkdir(__DIR__ . "/../.data");
        }
    }

    function testGeneratingRandomPngImage()
    {
        $filename = __DIR__ . "/../.data/test_image_13.png";
        FakeImage::create(500, 500, new RandomImageGenerator(13))
            ->generate()
            ->save($filename);
        $this->assertTrue(file_exists($filename));
    }

    function testGeneratingRandomJpgImage()
    {
        $filename = __DIR__ . "/../.data/test_image_8.jpg";
        FakeImage::create(500, 500, new RandomImageGenerator(8))
            ->generate()
            ->save($filename);
        $this->assertTrue(file_exists($filename));
    }

    function testGeneratingRandomJpegImage()
    {
        $filename = __DIR__ . "/../.data/test_image_33.jpeg";
        FakeImage::create(500, 500, new RandomImageGenerator(33))
            ->generate()
            ->save($filename);
        $this->assertTrue(file_exists($filename));
    }

    function testGeneratingRandomGifImage()
    {
        $filename = __DIR__ . "/../.data/test_image_21.gif";
        FakeImage::create(500, 500, new RandomImageGenerator(21))
            ->generate()
            ->save($filename);
        $this->assertTrue(file_exists($filename));
    }

}