<?php
namespace Test;

use PHPUnit\Framework\TestCase;

class SomeTest extends TestCase
{
    public function test_01()
    {
        $a = 1;
        $b = 2;
        $c = 3;
        assert(($a + ($b + 3)) === ($c * 3));
    }

    public function test_02()
    {
        $a = 'abc';
        $b = 'xyz';
        assert($a == strrev($b));
    }

    public function test_03()
    {
        $a = [1,2,3];
        $b = [7,8,9];
        assert($a == array_reverse($b));
    }

    public function test_ok()
    {
        $a = [1,2,3];
        $b = [3,2,1];
        assert($a == array_reverse($b));
    }
}
