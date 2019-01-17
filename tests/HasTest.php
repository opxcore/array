<?php

use PHPUnit\Framework\TestCase;
use OpxCore\Arr\Arr;

class HasTest extends TestCase
{
   public function runHasTest($array, $keys, $expected): void
    {
        $result = Arr::has($array, $keys);

        $this->assertEquals($expected, $result);
    }

    public function test_Not_Array(): void
    {
        $array = 'value';
        $keys = 'key';
        $expected = false;

        $this->runHasTest($array, $keys, $expected);
    }

    public function test_Null_Array(): void
    {
        $array = null;
        $keys = 'key';
        $expected = false;

        $this->runHasTest($array, $keys, $expected);
    }

    public function test_Empty_Array(): void
    {
        $array = [];
        $keys = 'key';
        $expected = false;

        $this->runHasTest($array, $keys, $expected);
    }

    public function test_Null_Keys(): void
    {
        $array = ['k1' => 'v1'];
        $keys = null;
        $expected = false;

        $this->runHasTest($array, $keys, $expected);
    }

    public function test_Empty_Keys(): void
    {
        $array = ['k1' => 'v1'];
        $keys = '';
        $expected = false;

        $this->runHasTest($array, $keys, $expected);
    }

    public function test_Empty_Array_Keys(): void
    {
        $array = ['k1' => 'v1'];
        $keys = [];
        $expected = false;

        $this->runHasTest($array, $keys, $expected);
    }

    public function test_One_Key_Simple_Array_Has(): void
    {
        $array = ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3'];
        $keys = 'k3';
        $expected = true;

        $this->runHasTest($array, $keys, $expected);
    }

    public function test_One_Key_Simple_Array_Has_No(): void
    {
        $array = ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3'];
        $keys = 'k4';
        $expected = false;

        $this->runHasTest($array, $keys, $expected);
    }

    public function test_Two_Keys_Simple_Array_Has(): void
    {
        $array = ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3'];
        $keys = ['k1', 'k3'];
        $expected = true;

        $this->runHasTest($array, $keys, $expected);
    }

    public function test_Two_Keys_Simple_Array_Has_No_One(): void
    {
        $array = ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3'];
        $keys = ['k1', 'k4'];
        $expected = false;

        $this->runHasTest($array, $keys, $expected);
    }

    public function test_Two_Keys_Simple_Array_Has_No_One_Another(): void
    {
        $array = ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3'];
        $keys = ['k4', 'k1'];
        $expected = false;

        $this->runHasTest($array, $keys, $expected);
    }

    public function test_Two_Keys_Simple_Array_Has_No_All(): void
    {
        $array = ['k1' => 'v1', 'k2' => 'v2', 'k3' => 'v3'];
        $keys = ['k4', 'k5'];
        $expected = false;

        $this->runHasTest($array, $keys, $expected);
    }

    public function test_One_Key_Deep_Array_Has(): void
    {
        $array = ['k1_1' => ['k1_2' => 'val1'], 'k2_1' => ['k2_2' => 'val2'], 'k3_1' => ['k3_2' => 'val3']];
        $keys = 'k2_1.k2_2';
        $expected = true;

        $this->runHasTest($array, $keys, $expected);
    }

    public function test_One_Key_Deep_Array_Has_Array(): void
    {
        $array = ['k1_1' => ['k1_2' => 'val1'], 'k2_1' => ['k2_2' => 'val2'], 'k3_1' => ['k3_2' => 'val3']];
        $keys = 'k2_1';
        $expected = true;

        $this->runHasTest($array, $keys, $expected);
    }

    public function test_One_Key_Deep_Array_Has_No_Deeper(): void
    {
        $array = ['k1_1' => ['k1_2' => 'val1'], 'k2_1' => ['k2_2' => 'val2'], 'k3_1' => ['k3_2' => 'val3']];
        $keys = 'k2_1.k2_2.k2_3';
        $expected = false;

        $this->runHasTest($array, $keys, $expected);
    }

}