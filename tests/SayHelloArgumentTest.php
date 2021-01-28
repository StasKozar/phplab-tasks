<?php


use PHPUnit\Framework\TestCase;

class SayHelloArgumentTest extends TestCase
{
    /**
     * @param mixed $argument
     * @param string $expected
     * @dataProvider argumentDataProvider
     */
    public function testSayHelloArgument($argument, string $expected)
    {
        $this->assertEquals($expected, sayHelloArgument($argument));
    }

    /**
     * @return array[]
     */
    public function argumentDataProvider(): array
    {
        return  [
            ['Sam', 'Hello Sam'],
            [1, 'Hello 1'],
            [true, 'Hello 1'],
            [false, 'Hello '],
        ];
    }
}