<?php
$i = 1;
$j = 2;
$n = 1;
$m = -1;
(\ngyuki\Phpower\Recorder::init()->expr(\ngyuki\Phpower\Recorder::cap('++$i === $j-- && +$n === -$m && $n === ~$m && false',\ngyuki\Phpower\Recorder::cap('++$i === $j-- && +$n === -$m && $n === ~$m',\ngyuki\Phpower\Recorder::cap('++$i === $j-- && +$n === -$m',\ngyuki\Phpower\Recorder::cap('++$i === $j--',\ngyuki\Phpower\Recorder::cap('++$i',++$i) ===\ngyuki\Phpower\Recorder::cap('$j--', $j--)) &&\ngyuki\Phpower\Recorder::cap('+$n === -$m', +\ngyuki\Phpower\Recorder::cap('$n',$n) === -\ngyuki\Phpower\Recorder::cap('$m',$m))) &&\ngyuki\Phpower\Recorder::cap('$n === ~$m',\ngyuki\Phpower\Recorder::cap('$n', $n) === ~\ngyuki\Phpower\Recorder::cap('$m',$m))) && false)) ? \PHPUnit\Framework\Assert::assertTrue(true) : \PHPUnit\Framework\Assert::fail(\ngyuki\Phpower\Recorder::dump()));
