<?php declare(strict_types=1);
namespace ngyuki\Phpower;

class Loader
{
    private static $registered = false;

    public static function load(string $filename, callable $translator)
    {
        if (self::$registered === false) {
            stream_filter_register('phpower', StreamFilter::class);
            self::$registered = true;
        }
        StreamFilter::$translator = $translator;
        try {
            /** @noinspection PhpIncludeInspection */
            return include "php://filter/read=phpower/resource={$filename}";
        } finally {
            StreamFilter::$translator = null;
        }
    }
}
