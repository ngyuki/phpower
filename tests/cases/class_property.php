<?php
class ClassPropertyCase
{
    public static $f = 1;
}

return [
    function () {
        assert(ClassPropertyCase::$f === 2);
    },
    function () {
        $c = new ClassPropertyCase();
        assert($c::$f === 2);
    },
];
