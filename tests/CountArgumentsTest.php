<?php

use PHPUnit\Framework\TestCase;

class CountArgumentsTest extends TestCase
{
    public function testCountArgumentsWithoutArgument()
    {
        $this->assertEquals(
            [
                'argument_count' => 0,
                'argument_values' => [],
            ],
            countArguments()
        );
    }

    public function testCountArguments()
    {
        $this->assertEquals(
            [
                'argument_count' => 1,
                'argument_values' => ['test'],
            ],
            countArguments('test')
        );
    }

    public function testCountWithMultipleArguments()
    {
        $this->assertEquals(
            [
                'argument_count' => 4,
                'argument_values' => ['test', [1,2,3], 10.0, true],
            ],
            countArguments('test', [1,2,3], 10.0, true)
        );
    }
}