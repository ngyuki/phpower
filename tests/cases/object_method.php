<?php
$o = new class {
    public function get()
    {
        return 1;
    }
};
assert($o->get() === 2);
