<?php
$o = new stdClass();
$o->a = 1;
(\ngyuki\Phpower\Recorder::init()->expr(\ngyuki\Phpower\Recorder::cap('$o->a === 2',\ngyuki\Phpower\Recorder::cap('$o->a',\ngyuki\Phpower\Recorder::cap('$o',$o)->a) === 2)) ? \PHPUnit\Framework\Assert::assertTrue(true) : \PHPUnit\Framework\Assert::fail(\ngyuki\Phpower\Recorder::dump()));
