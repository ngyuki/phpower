<?php
$i = 1;
$j = 2;
$n = 1;
$m = -1;
assert(++$i === $j-- && +$n === -$m && $n === ~$m && false);
