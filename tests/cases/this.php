<?php
$o = new class {
    public function test()
    {
        assert($this->get() === 2);
    }
    public function get()
    {
        return 1;
    }
};
$o->test();
