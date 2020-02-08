<?php
return [
    function () {
        $a = null;
        (\ngyuki\Phpower\Recorder::init()->expr(\ngyuki\Phpower\Recorder::cap('isset($a)',isset($a))) ? \PHPUnit\Framework\Assert::assertTrue(true) : \PHPUnit\Framework\Assert::fail(\ngyuki\Phpower\Recorder::dump()));
    },
    function () {
        $a = [];
        $i = 1;
        (\ngyuki\Phpower\Recorder::init()->expr(\ngyuki\Phpower\Recorder::cap('isset($a[$i + 1])',isset(\ngyuki\Phpower\Recorder::cap('$a',$a)[\ngyuki\Phpower\Recorder::cap('$i + 1',\ngyuki\Phpower\Recorder::cap('$i',$i)+1)]))) ? \PHPUnit\Framework\Assert::assertTrue(true) : \PHPUnit\Framework\Assert::fail(\ngyuki\Phpower\Recorder::dump()));
    },
    function () {
        $a = [];
        $i = 1;
        $j = 2;
        (\ngyuki\Phpower\Recorder::init()->expr(\ngyuki\Phpower\Recorder::cap('isset($a[$i + 1][$j + 2])',isset(\ngyuki\Phpower\Recorder::cap('$a',$a)[\ngyuki\Phpower\Recorder::cap('$i + 1',\ngyuki\Phpower\Recorder::cap('$i',$i)+1)][\ngyuki\Phpower\Recorder::cap('$j + 2',\ngyuki\Phpower\Recorder::cap('$j',$j)+2)]))) ? \PHPUnit\Framework\Assert::assertTrue(true) : \PHPUnit\Framework\Assert::fail(\ngyuki\Phpower\Recorder::dump()));
    },
    function () {
        $o = new stdClass();
        $i = 1;
        $j = 2;
        (\ngyuki\Phpower\Recorder::init()->expr(\ngyuki\Phpower\Recorder::cap('isset($o->{$i + 1}->{$j + 2})',isset(\ngyuki\Phpower\Recorder::cap('$o',$o)->{\ngyuki\Phpower\Recorder::cap('$i + 1',\ngyuki\Phpower\Recorder::cap('$i',$i)+1)}->{\ngyuki\Phpower\Recorder::cap('$j + 2',\ngyuki\Phpower\Recorder::cap('$j',$j)+2)}))) ? \PHPUnit\Framework\Assert::assertTrue(true) : \PHPUnit\Framework\Assert::fail(\ngyuki\Phpower\Recorder::dump()));
    },
    function () {
        $o = new stdClass();
        $i = 1;
        $j = 2;
        (\ngyuki\Phpower\Recorder::init()->expr(\ngyuki\Phpower\Recorder::cap('isset($o::$v[$i + 1][$j + 2])',isset(\ngyuki\Phpower\Recorder::cap('$o',$o)::$v[\ngyuki\Phpower\Recorder::cap('$i + 1',\ngyuki\Phpower\Recorder::cap('$i',$i)+1)][\ngyuki\Phpower\Recorder::cap('$j + 2',\ngyuki\Phpower\Recorder::cap('$j',$j)+2)]))) ? \PHPUnit\Framework\Assert::assertTrue(true) : \PHPUnit\Framework\Assert::fail(\ngyuki\Phpower\Recorder::dump()));
    },
];
