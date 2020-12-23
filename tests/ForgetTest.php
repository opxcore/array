<?php

use PHPUnit\Framework\TestCase;
use OpxCore\Arr\Arr;

class ForgetTest extends TestCase
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

    public function testNullKeys(): void
    {
        $array = $this->simpleArray;

        $result = Arr::forget($array, null);

        self::assertEquals($this->simpleArray, $result);

        self::assertEquals($array, $result);
    }

    public function testEmptyKeys(): void
    {
        $array = $this->simpleArray;

        $result = Arr::forget($array, '');

        self::assertEquals($this->simpleArray, $result);

        self::assertEquals($array, $result);
    }

    public function testEmptyArrayKeys(): void
    {
        $array = $this->simpleArray;

        $result = Arr::forget($array, []);

        self::assertEquals($this->simpleArray, $result);
    }

    public function testSimpleArrayOneKey(): void
    {
        $array = $this->simpleArray;

        $result = Arr::forget($array, 'k2');

        self::assertEquals(['k1' => 'v1'], $result);

        self::assertEquals($array, $result);
    }

    public function testSimpleArrayMultipleKey(): void
    {
        $array = $this->simpleArray + ['k3' => 'v3'];

        $result = Arr::forget($array, ['k1', 'k2']);

        self::assertEquals(['k3' => 'v3'], $result);

        self::assertEquals($array, $result);
    }

    public function testDeepArrayOneKey(): void
    {
        $array = $this->deepArray;

        $result = Arr::forget($array, 'k1.k1_1.k1_2');

        self::assertEquals([
            'k1' => [
                'k1_1' => [],
                'k1_2' => 'v2'
            ]
        ], $result);

        self::assertEquals($array, $result);
    }

    public function testDeepArrayOneKeyTwo(): void
    {
        $array = $this->deepArray;

        $result = Arr::forget($array, 'k1.k1_1');

        self::assertEquals([
            'k1' => [
                'k1_2' => 'v2'
            ]
        ], $result);

        self::assertEquals($array, $result);
    }

    public function testDeepArrayOneKeyMore(): void
    {
        $array = $this->deepArray;

        $result = Arr::forget($array, 'k1.k1_2.kn');

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

    public function testDeepArrayOneKeyAndMore(): void
    {
        $array = $this->deepArray;

        $result = Arr::forget($array, 'k1.k1_2.kn.kt');

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

    public function testDeepArrayOneKeys(): void
    {
        $array = $this->deepArray;

        $result = Arr::forget($array, 'k1.k1_1');

        self::assertEquals([
            'k1' => [
                'k1_2' => 'v2'
            ]
        ], $result);

        self::assertEquals($array, $result);
    }

    public function testDeepArrayMultiplyKeys(): void
    {
        $array = $this->deepArray;

        $result = Arr::forget($array, ['k1.k1_1.k1_2', 'k1.k1_2']);

        self::assertEquals([
            'k1' => [
                'k1_1' => [],
            ]
        ], $result);

        self::assertEquals($array, $result);
    }

}
