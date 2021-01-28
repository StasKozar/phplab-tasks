<?php


use PHPUnit\Framework\TestCase;

class SayHelloArgumentWrapperTest extends TestCase
{
    public function testSayHelloArgumentWithException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The wrong argument value.');
        sayHelloArgumentWrapper(['test']);
    }
}