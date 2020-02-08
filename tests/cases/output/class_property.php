<?php
class ClassPropertyCase
{
    public static $f = 1;
}

return [
    function () {
        (\ngyuki\Phpower\Recorder::init()->expr(\ngyuki\Phpower\Recorder::cap('ClassPropertyCase::$f === 2',\ngyuki\Phpower\Recorder::cap('ClassPropertyCase::$f',ClassPropertyCase::$f) === 2)) ? \PHPUnit\Framework\Assert::assertTrue(true) : \PHPUnit\Framework\Assert::fail(\ngyuki\Phpower\Recorder::dump()));
    },
    function () {
        $c = new ClassPropertyCase();
        (\ngyuki\Phpower\Recorder::init()->expr(\ngyuki\Phpower\Recorder::cap('$c::$f === 2',\ngyuki\Phpower\Recorder::cap('$c::$f',\ngyuki\Phpower\Recorder::cap('$c',$c)::$f) === 2)) ? \PHPUnit\Framework\Assert::assertTrue(true) : \PHPUnit\Framework\Assert::fail(\ngyuki\Phpower\Recorder::dump()));
    },
];
