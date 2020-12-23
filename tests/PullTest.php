<?php

use PHPUnit\Framework\TestCase;
use OpxCore\Arr\Arr;

class PullTest extends TestCase
{
    protected array $simpleArray = [
        'k1' => 'v1',
        'k2' => 'v2',
    ];

    protected array $deepArray = [
        'k1' => [
            'k1_1' => [
                'k1_2' => 'v1_1',
            ],
            'k1_2' => 'v2',
        ],
    ];

    public function testPullSimpleEmptyArray(): void
    {
        $array = [];

        $result = Arr::pull($array, 'd', -1);

        self::assertEquals(-1, $result);
    }

    public function testPullDeepArray(): void
    {
        $array = $this->deepArray;

        $result = Arr::pull($array, 'k1.k1_1');

        self::assertEquals(['k1_2' => 'v1_1'], $result);

        self::assertEquals([
            'k1' => [
                'k1_2' => 'v2',
            ],
        ], $array);
    }
}
