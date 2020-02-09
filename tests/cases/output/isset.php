<?php
return [
    function () {
        (\ngyuki\Phpower\Recorder::init()->expr(\ngyuki\Phpower\Recorder::cap('isset($v)',isset($v))) ? \PHPUnit\Framework\Assert::assertTrue(true) : \PHPUnit\Framework\Assert::fail(\ngyuki\Phpower\Recorder::dump()));
    },
    function () {
        $i = 1;
        (\ngyuki\Phpower\Recorder::init()->expr(\ngyuki\Phpower\Recorder::cap('isset($a[$i + 1])',isset($a[\ngyuki\Phpower\Recorder::cap('$i + 1',\ngyuki\Phpower\Recorder::cap('$i',$i)+1)]))) ? \PHPUnit\Framework\Assert::assertTrue(true) : \PHPUnit\Framework\Assert::fail(\ngyuki\Phpower\Recorder::dump()));
    },
    function () {
        $i = 1;
        $j = 2;
        (\ngyuki\Phpower\Recorder::init()->expr(\ngyuki\Phpower\Recorder::cap('isset($a[$i + 1][$j + 2])',isset($a[\ngyuki\Phpower\Recorder::cap('$i + 1',\ngyuki\Phpower\Recorder::cap('$i',$i)+1)][\ngyuki\Phpower\Recorder::cap('$j + 2',\ngyuki\Phpower\Recorder::cap('$j',$j)+2)]))) ? \PHPUnit\Framework\Assert::assertTrue(true) : \PHPUnit\Framework\Assert::fail(\ngyuki\Phpower\Recorder::dump()));
    },
    function () {
        $i = 1;
        $j = 2;
        (\ngyuki\Phpower\Recorder::init()->expr(\ngyuki\Phpower\Recorder::cap('isset($o->{$i + 1}->{$j + 2})',isset($o->{\ngyuki\Phpower\Recorder::cap('$i + 1',\ngyuki\Phpower\Recorder::cap('$i',$i)+1)}->{\ngyuki\Phpower\Recorder::cap('$j + 2',\ngyuki\Phpower\Recorder::cap('$j',$j)+2)}))) ? \PHPUnit\Framework\Assert::assertTrue(true) : \PHPUnit\Framework\Assert::fail(\ngyuki\Phpower\Recorder::dump()));
    },
    function () {
        $o = new stdClass();
        $i = 1;
        $j = 2;
        (\ngyuki\Phpower\Recorder::init()->expr(\ngyuki\Phpower\Recorder::cap('isset($o::$v[$i + 1][$j + 2])',isset($o::$v[\ngyuki\Phpower\Recorder::cap('$i + 1',\ngyuki\Phpower\Recorder::cap('$i',$i)+1)][\ngyuki\Phpower\Recorder::cap('$j + 2',\ngyuki\Phpower\Recorder::cap('$j',$j)+2)]))) ? \PHPUnit\Framework\Assert::assertTrue(true) : \PHPUnit\Framework\Assert::fail(\ngyuki\Phpower\Recorder::dump()));
    },
];
