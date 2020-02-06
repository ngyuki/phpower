<?php
namespace Test;

use PHPUnit\Framework\TestCase;

class SomeTest extends TestCase
{
    public function test()
    {
        $ary = [1,2,3];
        $zero = 0;
        $two = 2;
        assert(array_search($zero, $ary, true) === $two);
    }

    public function test_01()
    {
        $a = 1;
        $b = 2;
        $c = 3;
        assert(($a + ($b + 3)) === ($c * 3));
    }

    public function test_02()
    {
        $s = "x\ny\nz";
        assert("a\nb\nc" === strrev($s));
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
    public function test_04()
    {
        $a = [
            'name' => 'alice',
            'uid' => 1000,
            'gid' => 1000,
        ];
        assert($a == [
            'name' => 'bob',
            'uid' => 2000,
            'gid' => 2000,
        ]);
    }
}
