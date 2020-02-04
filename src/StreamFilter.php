<?php declare(strict_types=1);
namespace ngyuki\Phpower;

use php_user_filter;

/**
 * @property resource $stream
 * @property string $filtername
 */
class StreamFilter extends php_user_filter
{
    /**
     * @var callable|null
     */
    public static $translator = null;

    /**
     * @var string
     */
    private $source = '';

    public static function register(): void
    {
        stream_filter_register('phpower', static::class);
    }

    public static function load(string $filename, callable $translator)
    {
        static::$translator = $translator;
        try {
            /** @noinspection PhpIncludeInspection */
            return include "php://filter/read=phpower/resource={$filename}";
        } finally {
            static::$translator = null;
        }
    }

    public function onCreate()
    {
        return true;
    }

    public function onClose()
    {
        // noop
    }

    public function filter($in, $out, &$consumed, $closing)
    {
        while ($bucket = stream_bucket_make_writeable($in)) {
            $this->source .= $bucket->data;
            $consumed += $bucket->datalen;
        }
        if ($closing) {
            $source = $this->source;
            if ($translator = static::$translator) {
                $source = $translator($source);
            }
            $bucket = stream_bucket_new($this->stream, $source);
            assert(is_object($bucket));
            stream_bucket_append($out, $bucket);
            $this->source = '';
        }
        return PSFS_PASS_ON;
    }
}
