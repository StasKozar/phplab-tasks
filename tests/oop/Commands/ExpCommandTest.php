<?php

namespace oop\Commands;

use PHPUnit\Framework\TestCase;
use src\oop\Commands\ExpCommand;

class ExpCommandTest extends TestCase
{
    /**
     * @param float $firstArg
     * @param float $secondArg
     * @param float $expected
     *
     * @return void
     * @dataProvider expCommandDataProvider
     */
    public function testExecute(float $firstArg, float $secondArg, float $expected): void
    {
        $subCommand = new ExpCommand();

        $this->assertEquals($expected, $subCommand->execute($firstArg, $secondArg));
    }

    /**
     * @return array[]
     */
    public function expCommandDataProvider(): array
    {
        return [
            [
                2, 2, 4,
            ],
            [
                3, 3, 27,
            ],
            [
                4, 0, 1,
            ],
        ];
    }
}