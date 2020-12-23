<?php

use PHPUnit\Framework\TestCase;
use OpxCore\Arr\Arr;


class DotTest extends TestCase
{
    public function dotTestRun($set, $expected): void
    {
        $result = Arr::dot($set);

        self::assertEquals($expected, $result);
    }
    public function testEmptyArray(): void
    {
        $set = [];
        $expected = [];
        $this->dotTestRun($set, $expected);
    }

    public function testSingleLevelArray(): void
    {
        $set = [
            'k1' => 'v1',
            'k2' => 'v2',
        ];
        $expected = [
            'k1' => 'v1',
            'k2' => 'v2',
        ];
        $this->dotTestRun($set, $expected);
    }

    public function testMultidimensionalArray(): void
    {
        $set = [
            'k1' => [
                'k1_1' => 'v1_1',
            ],
            'k2' => [
                'k2_1' => 'v2_1',
                'k2_2' => [
                    'k3_1' => 'v3_1',
                ],
            ],
        ];
        $expected = [
            'k1.k1_1' => 'v1_1',
            'k2.k2_1' => 'v2_1',
            'k2.k2_2.k3_1' => 'v3_1',
        ];
        $this->dotTestRun($set, $expected);
    }

    public function testMultidimensionalArrayWithUnassociated(): void
    {
        $set = [
            'k1' => [
                'k1_1' => 'v1_1',
            ],
            'k2' => [
                'k2_1' => 'v2_1',
                'k2_2' => [
                    'v3_1', 'v3_2',
                ],
            ],
        ];
        $expected = [
            'k1.k1_1' => 'v1_1',
            'k2.k2_1' => 'v2_1',
            'k2.k2_2' => ['v3_1', 'v3_2'],
        ];
        $this->dotTestRun($set, $expected);
    }
}