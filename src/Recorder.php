<?php /** @noinspection PhpUnused */

namespace ngyuki\Phpower;

class Recorder
{
    public static $assertions = [];

    public static function init()
    {
        self::$assertions = [];
        return new self();
    }

    public function expr($variable)
    {
        if ($variable) {
            self::$assertions = [];
        }
        return $variable;
    }

    public static function dump()
    {
        return (new Reporter())->report(self::$assertions);
    }

    public static function cap(string $expression, $variable)
    {
        self::$assertions[]   = [$expression, $variable];
        return $variable;
    }
}
