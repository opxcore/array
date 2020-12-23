<?php

use PHPUnit\Framework\TestCase;
use OpxCore\Arr\Arr;

class HasTest extends TestCase
{
   public function runHasTest($array, $keys, $expected): void
    {
        $result = Arr::has($array, $keys);

        self::assertEquals($expected, $result);
    }

    public function testEmptyArray(): void
    {
        $array = [];
        $keys = 'key';
        $expected = false;

        $this->runHasTest($array, $keys, $expected);
    }

    public function testNullKeys(): void
    {
        $array = ['k1' => 'v1'];
        $keys = null;
        $expected = false;

        $this->runHasTest($array, $keys, $expected);
    }

    public function testEmptyKeys(): void
    {
        $array = ['k1' => 'v1'];
        $keys = '';
        $expected = false;

        $this->runHasTest($array, $keys, $expected);
    }

    public function testEmptyArrayKeys(): void
    {
        $array = ['k1' => 'v1'];
        $keys = [];
        $expected = false;

        $this->runHasTest($array, $keys, $expected);
    }

    public function testOneKeySimpleArrayHas(): void
    {
        $array = ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3'];
        $keys = 'k3';
        $expected = true;

        $this->runHasTest($array, $keys, $expected);
    }

    public function testOneKeySimpleArrayHasNo(): void
    {
        $array = ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3'];
        $keys = 'k4';
        $expected = false;

        $this->runHasTest($array, $keys, $expected);
    }

    public function testTwoKeysSimpleArrayHas(): void
    {
        $array = ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3'];
        $keys = ['k1', 'k3'];
        $expected = true;

        $this->runHasTest($array, $keys, $expected);
    }

    public function testTwoKeysSimpleArrayHasNoOne(): void
    {
        $array = ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3'];
        $keys = ['k1', 'k4'];
        $expected = false;

        $this->runHasTest($array, $keys, $expected);
    }

    public function testTwoKeysSimpleArrayHasNoOneAnother(): void
    {
        $array = ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3'];
        $keys = ['k4', 'k1'];
        $expected = false;

        $this->runHasTest($array, $keys, $expected);
    }

    public function testTwoKeysSimpleArrayHasNoAll(): void
    {
        $array = ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3'];
        $keys = ['k4', 'k5'];
        $expected = false;

        $this->runHasTest($array, $keys, $expected);
    }

    public function testOneKeyDeepArrayHas(): void
    {
        $array = ['k1_1' => ['k1_2' => 'val1'], 'k2_1' => ['k2_2' => 'val2'], 'k3_1' => ['k3_2' => 'val3']];
        $keys = 'k2_1.k2_2';
        $expected = true;

        $this->runHasTest($array, $keys, $expected);
    }

    public function testOneKeyDeepArrayHasArray(): void
    {
        $array = ['k1_1' => ['k1_2' => 'val1'], 'k2_1' => ['k2_2' => 'val2'], 'k3_1' => ['k3_2' => 'val3']];
        $keys = 'k2_1';
        $expected = true;

        $this->runHasTest($array, $keys, $expected);
    }

    public function testOneKeyDeepArrayHasNoDeeper(): void
    {
        $array = ['k1_1' => ['k1_2' => 'val1'], 'k2_1' => ['k2_2' => 'val2'], 'k3_1' => ['k3_2' => 'val3']];
        $keys = 'k2_1.k2_2.k2_3';
        $expected = false;

        $this->runHasTest($array, $keys, $expected);
    }

}