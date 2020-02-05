<?php
class ClassMethodCase
{
    public static function f()
    {
        return 1;
    }
}
(\ngyuki\Phpower\Recorder::init()->expr(\ngyuki\Phpower\Recorder::cap('ClassMethodCase::f() === 2',\ngyuki\Phpower\Recorder::cap('ClassMethodCase::f()',ClassMethodCase::f()) === 2)) ? \PHPUnit\Framework\Assert::assertTrue(true) : \PHPUnit\Framework\Assert::fail(\ngyuki\Phpower\Recorder::dump()));
