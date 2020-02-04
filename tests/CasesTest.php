<?php
namespace Test;

use ngyuki\Phpower\StreamFilter;
use ngyuki\Phpower\Transpiler;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

class CasesTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        $dir = escapeshellarg(__DIR__ . '/cases/output');
        `git checkout --  $dir`;
    }

    /**
     * @dataProvider data
     * @param string $file
     * @param string $dest
     */
    public function test(string $file, string $dest)
    {
        $expected = '';
        if (file_exists($dest)) {
            $expected = file_get_contents($dest);
        }
        try {
            StreamFilter::load($file, new Transpiler());
        } catch (AssertionFailedError $ex) {
            $normalizedMessage = $this->normalize($ex->getMessage());
            file_put_contents($dest, $normalizedMessage);
            assertInstanceOf(AssertionFailedError::class, $ex);
            assertEquals($expected, $normalizedMessage);
        }
    }

    public function data()
    {
        $files = glob(__DIR__ . '/cases/*.php');
        $tests = [];
        foreach ($files as $file) {
            $tests[basename($file)] = [$file, dirname($file) . '/output/' . basename($file, '.php') . '.txt'];
        }
        return $tests;
    }

    private function normalize($str)
    {
        return preg_replace('/#\d+/', '#999', $str);
    }
}
