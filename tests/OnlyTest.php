<?php

use PHPUnit\Framework\TestCase;
use OpxCore\Arr\Arr;

class OnlyTest extends TestCase
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
        $this->expectException(TypeError::class);

        Arr::only(null, 'k1');
    }

    public function testEmptyArray(): void
    {
        $result = Arr::only([], 'k1');

        self::assertEquals([], $result);
    }

    public function testNullKeys(): void
    {
        $result = Arr::only($this->simpleArray, null);

        self::assertEquals([], $result);
    }

    public function testEmptyKeys(): void
    {
        $result = Arr::only($this->simpleArray, '');

        self::assertEquals([], $result);
    }

    public function testEmptyArrayKeys(): void
    {
        $result = Arr::only($this->simpleArray, []);

        self::assertEquals([], $result);
    }

    public function testNotAssociativeArrayKeys(): void
    {
        $result = Arr::only(['dd'], 0);

        self::assertEquals(['dd'], $result);
    }

    public function testNotAssociativeArrayKeysNot(): void
    {
        $result = Arr::only(['dd'], 1);

        self::assertEquals([], $result);
    }

    public function testSimpleOneKey(): void
    {
        $result = Arr::only($this->simpleArray, 'k1');

        self::assertEquals(['k1' => 'v1'], $result);
    }

    public function testSimpleManyKey(): void
    {
        $result = Arr::only($this->simpleArray, ['k1', 'k2']);

        self::assertEquals(['k1' => 'v1', 'k2' => 'v2'], $result);
    }

}