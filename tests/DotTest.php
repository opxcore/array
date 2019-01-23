<?php

use PHPUnit\Framework\TestCase;
use OpxCore\Arr\Arr;

class DotTest extends TestCase
{
    public function dotTestRun($set, $expected): void
    {
        $result = Arr::dot($set);

        $this->assertEquals($expected, $result);
    }

    public function test_Not_Array(): void
    {
        $set = 'val';
        $expected = null;
        $this->dotTestRun($set, $expected);
    }

    public function test_Empty_Array(): void
    {
        $set = [];
        $expected = [];
        $this->dotTestRun($set, $expected);
    }

    public function test_Single_Level_Array(): void
    {
        $set = [
            'k1' => 'v1',
            'k2' => 'v2',
        ];
        $expected = [
            'k1' => 'v1',
            'k2' => 'v2',
        ];
        $this->dotTestRun($set, $expected);
    }

    public function test_Multidimensional_Array(): void
    {
        $set = [
            'k1' => [
                'k1_1' => 'v1_1',
            ],
            'k2' => [
                'k2_1' => 'v2_1',
                'k2_2' => [
                    'k3_1' => 'v3_1',
                ],
            ],
        ];
        $expected = [
            'k1.k1_1' => 'v1_1',
            'k2.k2_1' => 'v2_1',
            'k2.k2_2.k3_1' => 'v3_1',
        ];
        $this->dotTestRun($set, $expected);
    }

    public function test_Multidimensional_Array_With_Unassociated(): void
    {
        $set = [
            'k1' => [
                'k1_1' => 'v1_1',
            ],
            'k2' => [
                'k2_1' => 'v2_1',
                'k2_2' => [
                    'v3_1', 'v3_2',
                ],
            ],
        ];
        $expected = [
            'k1.k1_1' => 'v1_1',
            'k2.k2_1' => 'v2_1',
            'k2.k2_2' => ['v3_1', 'v3_2'],
        ];
        $this->dotTestRun($set, $expected);
    }
}