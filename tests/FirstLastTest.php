<?php

use PHPUnit\Framework\TestCase;
use OpxCore\Arr\Arr;

class FirstLastTest extends TestCase
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

    public function testFirstSimpleEmptyArray(): void
    {
        $result = Arr::first([], null, -1);

        self::assertEquals(-1, $result);
    }

    public function testFirstSimple(): void
    {
        $array = $this->simpleArray;

        $result = Arr::first($array);

        self::assertEquals('v1', $result);
    }

    public function testFirstSimpleClosure(): void
    {
        $array = $this->simpleArray;

        $result = Arr::first($array, function ($val, $key) {
            return $key === 'k2';
        });

        self::assertEquals('v2', $result);
    }

    public function testFirstSimpleClosureNot(): void
    {
        $array = $this->simpleArray;

        $result = Arr::first($array, function ($val, $key) {
            return $key === 'k3';
        });

        self::assertEquals(null, $result);
    }

    public function testLastSimpleEmptyArray(): void
    {
        $result = Arr::last([], null, -1);

        self::assertEquals(-1, $result);
    }

    public function testLastSimple(): void
    {
        $array = $this->simpleArray;

        $result = Arr::last($array);

        self::assertEquals('v2', $result);
    }

    public function testLastSimpleClosure(): void
    {
        $array = $this->simpleArray;

        $result = Arr::last($array, function ($val, $key) {
            return $key === 'k1';
        });

        self::assertEquals('v1', $result);
    }

    public function testLastSimpleClosureNot(): void
    {
        $array = $this->simpleArray;

        $result = Arr::last($array, function ($val, $key) {
            return $key === 'k3';
        });

        self::assertEquals(null, $result);
    }


}
