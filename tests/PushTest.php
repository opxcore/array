<?php

use PHPUnit\Framework\TestCase;
use OpxCore\Arr\Arr;

class PushTest extends TestCase
{
    public function pushTestRun($array, $key, $value, $expected): void
    {
        $result = Arr::push($array, $key, $value);

        $this->assertEquals($expected, $result);
        $this->assertEquals($array, $result);
    }

    public function test_Not_Array(): void
    {
        $array = 'val';
        $key = 'val';
        $value = 'val';
        $expected = null;

        $this->expectException(\InvalidArgumentException::class);

        $result = Arr::push($array, $key, $value);
    }

    public function test_Null_Array(): void
    {
        $array = null;
        $key = 'key';
        $value = 'val';
        $expected = ['key' => ['val']];

        $this->pushTestRun($array, $key, $value, $expected);
    }

    public function test_Empty_Array(): void
    {
        $array = [];
        $key = 'key';
        $value = 'val';
        $expected = ['key' => ['val']];

        $this->pushTestRun($array, $key, $value, $expected);
    }

    public function test_Push_To_Existing_Not_Array(): void
    {
        $array = ['key' => 'val1'];
        $key = 'key';
        $value = 'val2';
        $expected = ['key' => ['val1', 'val2']];

        $this->pushTestRun($array, $key, $value, $expected);
    }

    public function test_Push_To_Existing_Array(): void
    {
        $array = ['key' => ['val1']];
        $key = 'key';
        $value = 'val2';
        $expected = ['key' => ['val1', 'val2']];

        $this->pushTestRun($array, $key, $value, $expected);
    }

    public function test_Push_Deep_Not_Existing(): void
    {
        $array = ['key1' => ['key2' => 'val1']];
        $key = 'key1.key3';
        $value = 'val2';
        $expected = ['key1' => ['key2' => 'val1', 'key3' => ['val2']]];

        $this->pushTestRun($array, $key, $value, $expected);
    }

    public function test_Push_Deep_Existing(): void
    {
        $array = ['key1' => ['key2' => 'val1']];
        $key = 'key1.key2';
        $value = 'val2';
        $expected = ['key1' => ['key2' => ['val1', 'val2']]];

        $this->pushTestRun($array, $key, $value, $expected);
    }
}