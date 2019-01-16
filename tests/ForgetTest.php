<?php

use PHPUnit\Framework\TestCase;
use OpxCore\Arr\Arr;

class ForgetTest extends TestCase
{
    protected $simpleArray = [
        'k1' => 'v1',
        'k2' => 'v2',
    ];

    protected $deepArray = [
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

        $this->assertEquals($this->simpleArray, $result);

        $this->assertEquals($array, $result);
    }

    public function testEmptyKeys(): void
    {
        $array = $this->simpleArray;

        $result = Arr::forget($array, '');

        $this->assertEquals($this->simpleArray, $result);

        $this->assertEquals($array, $result);
    }

    public function testEmptyArrayKeys(): void
    {
        $array = $this->simpleArray;

        $result = Arr::forget($array, []);

        $this->assertEquals($this->simpleArray, $result);
    }

    public function testSimpleArrayOneKey(): void
    {
        $array = $this->simpleArray;

        $result = Arr::forget($array, 'k2');

        $this->assertEquals(['k1' => 'v1'], $result);

        $this->assertEquals($array, $result);
    }

    public function testSimpleArrayMultipleKey(): void
    {
        $array = $this->simpleArray + ['k3' => 'v3'];

        $result = Arr::forget($array, ['k1', 'k2']);

        $this->assertEquals(['k3' => 'v3'], $result);

        $this->assertEquals($array, $result);
    }

    public function testDeepArrayOneKey(): void
    {
        $array = $this->deepArray;

        $result = Arr::forget($array, 'k1.k1_1.k1_2');

        $this->assertEquals([
            'k1' => [
                'k1_1' => [],
                'k1_2' => 'v2'
            ]
        ], $result);

        $this->assertEquals($array, $result);
    }

    public function testDeepArrayOneKeys(): void
    {
        $array = $this->deepArray;

        $result = Arr::forget($array, 'k1.k1_1');

        $this->assertEquals([
            'k1' => [
                'k1_2' => 'v2'
            ]
        ], $result);

        $this->assertEquals($array, $result);
    }

    public function testDeepArrayMultiplyKeys(): void
    {
        $array = $this->deepArray;

        $result = Arr::forget($array, ['k1.k1_1.k1_2', 'k1.k1_2']);

        $this->assertEquals([
            'k1' => [
                'k1_1' => [],
            ]
        ], $result);

        $this->assertEquals($array, $result);
    }

}
