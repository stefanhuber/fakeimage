<?php

use PHPUnit\Framework\TestCase;
use FakeImage\Generators\RandomImageGenerator;

final class RandomImageGeneratorTest extends TestCase
{
    function testGridCombinationEqualSizes()
    {
        $generator = new RandomImageGenerator();
        $this->assertEquals([
            [0, 0, 4, 4],
            [0, 5, 4, 9],
            [5, 0, 9, 4],
            [5, 5, 9, 9]
        ], $generator->calculateCellCoordinates(5, 10, 10));
    }

    function testGridCombinationUnequalWidth()
    {
        $generator = new RandomImageGenerator();
        $this->assertEquals([
            [0, 0, 4, 4],
            [0, 5, 4, 9],
            [5, 0, 8, 4],
            [5, 5, 8, 9]
        ], $generator->calculateCellCoordinates(5, 9, 10));
    }

    function testGridCombinationUnequalHeight()
    {
        $generator = new RandomImageGenerator();
        $this->assertEquals([
            [0, 0, 4, 4],
            [0, 5, 4, 8],
            [5, 0, 9, 4],
            [5, 5, 9, 8]
        ], $generator->calculateCellCoordinates(5, 10, 9));
    }

    function testRandomColor()
    {
        $generator = new RandomImageGenerator();
        $randomColor = $generator->generateRandomColor();

        for ($i = 0; $i < 3; $i++) {
            $this->assertGreaterThanOrEqual(0, $randomColor[$i]);
            $this->assertLessThanOrEqual(255, $randomColor[$i]);
        }
    }

}