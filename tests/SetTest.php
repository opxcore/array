<?php

use PHPUnit\Framework\TestCase;
use OpxCore\Arr\Arr;

class SetTest extends TestCase
{
    public function testNullArray(): void
    {
        $array = null;

        $result = Arr::set($array, 'k1', 'v1');

        $this->assertEquals([
            'k1' => 'v1',
        ], $result);

        $this->assertEquals($array, $result);
    }

    public function testSetNotArray(): void
    {
        $array = 'var';

        $this->expectException(\InvalidArgumentException::class);

        Arr::set($array, 'k1', 'v1');
    }

    public function testSetEmptyKey(): void
    {
        $array = [];

        $this->expectException(\InvalidArgumentException::class);

        Arr::set($array, '', 'v1');
    }

    public function testSetNotStringKey(): void
    {
        $array = [];

        $this->expectException(\InvalidArgumentException::class);

        Arr::set($array, 5, 'v1');
    }

    public function testSetEmptyArraySingleLevel(): void
    {
        $array = [];

        Arr::set($array, 'k1', 'v1');
        $result = Arr::set($array, 'k2', 'v2');

        $this->assertEquals([
            'k1' => 'v1',
            'k2' => 'v2',
        ], $result);

        $this->assertEquals($array, $result);
    }

    public function testSetEmptyArrayDeepLevel(): void
    {
        $array = [];

        Arr::set($array, 'k1.k1_1', 'v1');
        $result = Arr::set($array, 'k1.k1_2', 'v2');

        $this->assertEquals([
            'k1' => [
                'k1_1' => 'v1',
                'k1_2' => 'v2',
            ],
        ], $result);

        $this->assertEquals($array, $result);
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

        $this->assertEquals([
            'k1' => [
                'k1_1' => [
                    'k1_2' => 'v1_1',
                ],
                'k1_2' => 'v2',
            ],
        ], $result);

        $this->assertEquals($array, $result);
    }
}