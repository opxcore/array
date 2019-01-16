<?php

use PHPUnit\Framework\TestCase;
use OpxCore\Arr\Arr;

class FirstLastTest extends TestCase
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

    public function testFirstSimpleEmptyArray(): void
    {
        $result = Arr::first([], null, -1);

        $this->assertEquals(-1, $result);
    }

    public function testFirstSimple(): void
    {
        $array = $this->simpleArray;

        $result = Arr::first($array);

        $this->assertEquals('v1', $result);
    }

    public function testFirstSimpleClosure(): void
    {
        $array = $this->simpleArray;

        $result = Arr::first($array, function ($val, $key) {
            return $key === 'k2';
        });

        $this->assertEquals('v2', $result);
    }

    public function testFirstSimpleClosureNot(): void
    {
        $array = $this->simpleArray;

        $result = Arr::first($array, function ($val, $key) {
            return $key === 'k3';
        });

        $this->assertEquals(null, $result);
    }

    public function testLastSimpleEmptyArray(): void
    {
        $result = Arr::last([], null, -1);

        $this->assertEquals(-1, $result);
    }

    public function testLastSimple(): void
    {
        $array = $this->simpleArray;

        $result = Arr::last($array);

        $this->assertEquals('v2', $result);
    }

    public function testLastSimpleClosure(): void
    {
        $array = $this->simpleArray;

        $result = Arr::last($array, function ($val, $key) {
            return $key === 'k1';
        });

        $this->assertEquals('v1', $result);
    }

    public function testLastSimpleClosureNot(): void
    {
        $array = $this->simpleArray;

        $result = Arr::last($array, function ($val, $key) {
            return $key === 'k3';
        });

        $this->assertEquals(null, $result);
    }


}
