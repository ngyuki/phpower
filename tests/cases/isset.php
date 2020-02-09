<?php
return [
    function () {
        assert(isset($v));
    },
    function () {
        $i = 1;
        assert(isset($a[$i+1]));
    },
    function () {
        $i = 1;
        $j = 2;
        assert(isset($a[$i+1][$j+2]));
    },
    function () {
        $i = 1;
        $j = 2;
        assert(isset($o->{$i+1}->{$j+2}));
    },
    function () {
        $o = new stdClass();
        $i = 1;
        $j = 2;
        assert(isset($o::$v[$i+1][$j+2]));
    },
];
