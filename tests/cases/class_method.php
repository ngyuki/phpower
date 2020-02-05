<?php
class ClassMethodCase
{
    public static function f()
    {
        return 1;
    }
}
assert(ClassMethodCase::f() === 2);
