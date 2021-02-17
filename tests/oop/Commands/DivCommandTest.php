<?php

namespace oop\Commands;

use PHPUnit\Framework\TestCase;
use src\oop\Commands\DivCommand;

class DivCommandTest extends TestCase
{
    /**
     * @param float $firstArg
     * @param float $secondArg
     * @param float $expected
     *
     * @return void
     * @dataProvider divCommandDataProvider
     */
    public function testExecute(float $firstArg, float $secondArg, float $expected): void
    {
        $subCommand = new DivCommand();

        $this->assertEquals($expected, $subCommand->execute($firstArg, $secondArg));
    }

    /**
     * @return array[]
     */
    public function divCommandDataProvider(): array
    {
        return [
            [
                9, 3, 3,
            ],
            [
                25, 5, 5,
            ],
            [
                19, 5, 3.8,
            ],
        ];
    }
}