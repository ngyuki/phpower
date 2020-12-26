<?php
class ObjectMethod
{
    public function get()
    {
        return 1;
    }

}
$o = new ObjectMethod();
(\ngyuki\Phpower\Recorder::init()->expr(\ngyuki\Phpower\Recorder::cap('$o->get() === 2',\ngyuki\Phpower\Recorder::cap('$o->get()',\ngyuki\Phpower\Recorder::cap('$o',$o)->get()) === 2)) ? \PHPUnit\Framework\Assert::assertTrue(true) : \PHPUnit\Framework\Assert::fail(\ngyuki\Phpower\Recorder::dump()));
