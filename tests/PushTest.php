<?php

use PHPUnit\Framework\TestCase;
use OpxCore\Arr\Arr;

class PushTest extends TestCase
{
    public function pushTestRun($array, $key, $value, $expected): void
    {
        $result = Arr::push($array, $key, $value);

        self::assertEquals($expected, $result);
        self::assertEquals($array, $result);
    }

    public function testEmptyArray(): void
    {
        $array = [];
        $key = 'key';
        $value = 'val';
        $expected = ['key' => ['val']];

        $this->pushTestRun($array, $key, $value, $expected);
    }

    public function testPushToExistingNotArray(): void
    {
        $array = ['key' => 'val1'];
        $key = 'key';
        $value = 'val2';
        $expected = ['key' => ['val1', 'val2']];

        $this->pushTestRun($array, $key, $value, $expected);
    }

    public function testPushToExistingArray(): void
    {
        $array = ['key' => ['val1']];
        $key = 'key';
        $value = 'val2';
        $expected = ['key' => ['val1', 'val2']];

        $this->pushTestRun($array, $key, $value, $expected);
    }

    public function testPushDeepNotExisting(): void
    {
        $array = ['key1' => ['key2' => 'val1']];
        $key = 'key1.key3';
        $value = 'val2';
        $expected = ['key1' => ['key2' => 'val1', 'key3' => ['val2']]];

        $this->pushTestRun($array, $key, $value, $expected);
    }

    public function testPushDeepExisting(): void
    {
        $array = ['key1' => ['key2' => 'val1']];
        $key = 'key1.key2';
        $value = 'val2';
        $expected = ['key1' => ['key2' => ['val1', 'val2']]];

        $this->pushTestRun($array, $key, $value, $expected);
    }
}