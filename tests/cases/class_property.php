<?php
class ClassPropertyCase
{
    public static $f = 1;
}
assert(ClassPropertyCase::$f === 2);
