<?php

use PHPUnit\Framework\TestCase;
use OpxCore\Arr\Arr;

class SetTest extends TestCase
{
    public function testNullArray(): void
    {
        $array = null;

        $result = Arr::set($array, 'k1', 'v1');

        self::assertEquals([
            'k1' => 'v1',
        ], $result);

        self::assertEquals($array, $result);
    }

    public function testSetEmptyKey(): void
    {
        $array = [];

        $this->expectException(InvalidArgumentException::class);

        Arr::set($array, '', 'v1');
    }

    public function testSetEmptyArraySingleLevel(): void
    {
        $array = [];

        Arr::set($array, 'k1', 'v1');
        $result = Arr::set($array, 'k2', 'v2');

        self::assertEquals([
            'k1' => 'v1',
            'k2' => 'v2',
        ], $result);

        self::assertEquals($array, $result);
    }

    public function testSetEmptyArrayDeepLevel(): void
    {
        $array = [];

        Arr::set($array, 'k1.k1_1', 'v1');
        $result = Arr::set($array, 'k1.k1_2', 'v2');

        self::assertEquals([
            'k1' => [
                'k1_1' => 'v1',
                'k1_2' => 'v2',
            ],
        ], $result);

        self::assertEquals($array, $result);
    }

    public function testSetEmptyArrayDeepOverwrite(): void
    {
        $array = [
            'k1' => [
                'k1_1' => 'v1',
                'k1_2' => 'v2',
            ],
        ];

        $result = Arr::set($array, 'k1.k1_1.k1_2', 'v1_1');

        self::assertEquals([
            'k1' => [
                'k1_1' => [
                    'k1_2' => 'v1_1',
                ],
                'k1_2' => 'v2',
            ],
        ], $result);

        self::assertEquals($array, $result);
    }
}