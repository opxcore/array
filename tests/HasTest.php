<?php

use PHPUnit\Framework\TestCase;
use OpxCore\Arr\Arr;

class HasTest extends TestCase
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
        $result = Arr::has(null, 'k1');

        $this->assertFalse($result);
    }

    public function testEmptyArray(): void
    {
        $result = Arr::has([], 'k1');

        $this->assertFalse($result);
    }

    public function testArrayNoKeys(): void
    {
        $result = Arr::has(['v1'], 'k1');

        $this->assertFalse($result);
    }

    public function testArrayNullKeys(): void
    {
        $result = Arr::has($this->simpleArray, null);

        $this->assertFalse($result);
    }

    public function testArrayEmptyKeys(): void
    {
        $result = Arr::has($this->simpleArray, '');

        $this->assertFalse($result);
    }

    public function testArrayEmptyArrayKeys(): void
    {
        $result = Arr::has($this->simpleArray, []);

        $this->assertFalse($result);
    }

    public function testSimpleSingleHas(): void
    {
        $result = Arr::has($this->simpleArray, 'k1');

        $this->assertTrue($result);
    }

    public function testSimpleSingleHasNot(): void
    {
        $result = Arr::has($this->simpleArray, 'k3');

        $this->assertFalse($result);
    }

    public function testSimpleMultipleHas(): void
    {
        $result = Arr::has($this->simpleArray, ['k1', 'k2']);

        $this->assertTrue($result);
    }

    public function testSimpleMultipleHasNotOne(): void
    {
        $result = Arr::has($this->simpleArray, ['k1', 'k3']);

        $this->assertFalse($result);
    }

    public function testSimpleMultipleHasNot(): void
    {
        $result = Arr::has($this->simpleArray, ['k3', 'k4']);

        $this->assertFalse($result);
    }

    public function testDeepMultipleHasOne(): void
    {
        $result = Arr::has($this->deepArray, 'k1.k1_1.k1_2');

        $this->assertTrue($result);
    }

    public function testDeepMultipleHasNotOne(): void
    {
        $result = Arr::has($this->deepArray, 'k1.k1_1.k1_3');

        $this->assertFalse($result);
    }

    public function testDeepMultipleHasMany(): void
    {
        $result = Arr::has($this->deepArray, ['k1.k1_1.k1_2', 'k1.k1_2']);

        $this->assertTrue($result);
    }

    public function testDeepMultipleHasNotMany(): void
    {
        $result = Arr::has($this->deepArray, ['k1.k1_1.k1_3', 'k1.k1_2']);

        $this->assertFalse($result);
    }

    public function testDeepMultipleHasNoMany(): void
    {
        $result = Arr::has($this->deepArray, ['k1.k1_1.k1_3', 'k2.k1_2']);

        $this->assertFalse($result);
    }

}