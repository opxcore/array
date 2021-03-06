<?php

use PHPUnit\Framework\TestCase;
use OpxCore\Arr\Arr;

class GetTest extends TestCase
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

    public function testNotArray(): void
    {
        $result = Arr::get(null, 'k1', -1);

        self::assertEquals(-1, $result);
    }

    public function testEmptyKey(): void
    {
        $result = Arr::get($this->simpleArray, '', -1);

        self::assertEquals(-1, $result);
    }

    public function testNullKey(): void
    {
        $result = Arr::get($this->simpleArray, null, -1);

        self::assertEquals(-1, $result);
    }

    public function testNotStringKey(): void
    {
        $result = Arr::get($this->simpleArray, 10, -1);

        self::assertEquals(-1, $result);
    }

    public function testClosureDefault(): void
    {
        $result = Arr::get($this->simpleArray, 10, function () {
            return -1;
        });

        self::assertEquals(-1, $result);
    }

    public function testSimple(): void
    {
        $result = Arr::get($this->simpleArray, 'k2');

        self::assertEquals('v2', $result);
    }

    public function testSimpleNotExists(): void
    {
        $result = Arr::get($this->simpleArray, 'k3');

        self::assertEquals(null, $result);
    }

    public function testDeep(): void
    {
        $result = Arr::get($this->deepArray, 'k1.k1_1.k1_2');

        self::assertEquals('v1_1', $result);
    }

    public function testDeepNotExists(): void
    {
        $result = Arr::get($this->deepArray, 'k1.k1_1.k1_3');

        self::assertEquals(null, $result);
    }

}