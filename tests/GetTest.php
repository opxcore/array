<?php

use PHPUnit\Framework\TestCase;
use OpxCore\Arr\Arr;

class GetTest extends TestCase
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

    public function testNotArray(): void
    {
        $result = Arr::get(null, 'k1', -1);

        $this->assertEquals(-1, $result);
    }

    public function testEmptyKey(): void
    {
        $result = Arr::get($this->simpleArray, '', -1);

        $this->assertEquals(-1, $result);
    }

    public function testNullKey(): void
    {
        $result = Arr::get($this->simpleArray, null, -1);

        $this->assertEquals(-1, $result);
    }

    public function testNotStringKey(): void
    {
        $result = Arr::get($this->simpleArray, 10, -1);

        $this->assertEquals(-1, $result);
    }

    public function testClosureDefault(): void
    {
        $result = Arr::get($this->simpleArray, 10, function () {
            return -1;
        });

        $this->assertEquals(-1, $result);
    }

    public function testSimple(): void
    {
        $result = Arr::get($this->simpleArray, 'k2');

        $this->assertEquals('v2', $result);
    }

    public function testSimpleNotExists(): void
    {
        $result = Arr::get($this->simpleArray, 'k3');

        $this->assertEquals(null, $result);
    }

    public function testDeep(): void
    {
        $result = Arr::get($this->deepArray, 'k1.k1_1.k1_2');

        $this->assertEquals('v1_1', $result);
    }

    public function testDeepNotExists(): void
    {
        $result = Arr::get($this->deepArray, 'k1.k1_1.k1_3');

        $this->assertEquals(null, $result);
    }

}