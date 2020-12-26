<?php
class ObjectMethod
{
    public function get()
    {
        return 1;
    }

}
$o = new ObjectMethod();
assert($o->get() === 2);
