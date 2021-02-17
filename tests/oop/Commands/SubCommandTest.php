<?php

namespace oop\Commands;

use PHPUnit\Framework\TestCase;
use src\oop\Commands\SubCommand;

class SubCommandTest extends TestCase
{
    /**
     * @param float $firstArg
     * @param float $secondArg
     * @param float $expected
     *
     * @return void
     * @dataProvider subCommandDataProvider
     */
    public function testExecute(float $firstArg, float $secondArg, float $expected): void
    {
        $subCommand = new SubCommand();

        $this->assertEquals($expected, $subCommand->execute($firstArg, $secondArg));
    }

    /**
     * @return array[]
     */
    public function subCommandDataProvider(): array
    {
        return [
            [
                5, 2, 3,
            ],
            [
                10, 5, 5,
            ],
            [
                15, 5, 10,
            ],
        ];
    }
}