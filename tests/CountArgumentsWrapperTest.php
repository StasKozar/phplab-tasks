<?php


use PHPUnit\Framework\TestCase;

class CountArgumentsWrapperTest extends TestCase
{
    public function testCountWithMultipleArguments()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument - 10 is not a string');
        countArgumentsWrapper('test', 'test2', 10, 'true');
    }
}