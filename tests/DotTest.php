<?php

use PHPUnit\Framework\TestCase;
use OpxCore\Arr\Arr;

class DotTest extends TestCase
{
    public function testDotNotArray(): void
    {
        $result = Arr::dot('val');

        $this->assertEquals(null, $result);
    }

    public function testDotEmptyArray(): void
    {
        $result = Arr::dot([]);

        $this->assertEquals([], $result);
    }

    public function testSingleLevelArray(): void
    {
        $result = Arr::dot([
            'k1' => 'v1',
            'k2' => 'v2',
        ]);

        $this->assertEquals([
            'k1' => 'v1',
            'k2' => 'v2',
        ], $result);
    }

    public function testTwoLevelArray(): void
    {
        $result = Arr::dot([
            'k1' => [
                'k1_1' => 'v1_1',
            ],
            'k2' => [
                'k2_1' => 'v2_1',
                'k2_2' => 'v2_2',
            ]
        ]);

        $this->assertEquals([
            'k1.k1_1' => 'v1_1',
            'k2.k2_1' => 'v2_1',
            'k2.k2_2' => 'v2_2',
        ], $result);
    }
}