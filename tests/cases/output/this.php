<?php
$o = new class {
    public function test()
    {
        (\ngyuki\Phpower\Recorder::init()->expr(\ngyuki\Phpower\Recorder::cap('$this->get() === 2',\ngyuki\Phpower\Recorder::cap('$this->get()',$this->get()) === 2)) ? \PHPUnit\Framework\Assert::assertTrue(true) : \PHPUnit\Framework\Assert::fail(\ngyuki\Phpower\Recorder::dump()));
    }
    public function get()
    {
        return 1;
    }
};
$o->test();
