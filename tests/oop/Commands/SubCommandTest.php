<?php

namespace oop\Commands;

use PHPUnit\Framework\TestCase;
use src\oop\Commands\SubCommand;

class SubCommandTest extends TestCase
{
    /**
     * @param array $args
     * @param int $expected
     *
     * @return void
     * @dataProvider
     */
    public function testExecute(array $args, int $expected): void
    {
        $subCommand = $this->createMock(SubCommand::class);

        $this->assertEquals($expected, $subCommand->execute($args));
    }

    public function subCommandDataProvider()
    {
        return [
            [
                [5, 2],
                3
            ],
            [
                [10, 5],
                5
            ],
            [
                [15, 5],
                10
            ],
        ];
    }
}