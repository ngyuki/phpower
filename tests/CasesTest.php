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
        `git clean -f --  $dir`;
    }

    /**
     * @test
     * @dataProvider data
     * @param string $file
     * @param string $dest
     */
    public function transpiler(string $file, string $dest)
    {
        $dest .= '.php';
        $source = file_get_contents($file);
        $output = (new Transpiler())($source);
        file_put_contents($dest, $output);
        self::assertTrue(true);
    }

    /**
     * @test
     * @dataProvider data
     * @param string $file
     * @param string $dest
     */
    public function tree(string $file, string $dest)
    {
        $dest .= '.tree.txt';
        $source = file_get_contents($file);
        ob_start();
        try {
            (new Transpiler())->withDebug()($source);
        } finally {
            $output = ob_get_clean();
        }
        file_put_contents($dest, $output);
        self::assertTrue(true);
    }

    /**
     * @test
     * @dataProvider data
     * @param string $file
     * @param string $dest
     */
    public function assertion(string $file, string $dest)
    {
        $expected = '';
        $dest .= '.txt';
        if (file_exists($dest)) {
            $expected = file_get_contents($dest);
        }
        $output = [];
        $funcs = [];
        try {
            $funcs = StreamFilter::load($file, new Transpiler());
        } catch (AssertionFailedError $ex) {
            $output[] = $this->normalize($ex->getMessage());
        }
        if ($funcs) {
            foreach ($funcs as $func) {
                try {
                    $func();
                } catch (AssertionFailedError $ex) {
                    $output[] = $this->normalize($ex->getMessage());
                }
            }
        }
        $output = implode("\n", $output);
        file_put_contents($dest, $output);
        self::assertEquals($expected, $output);
    }

    public function data()
    {
        $files = glob(__DIR__ . '/cases/*.php');
        $tests = [];
        foreach ($files as $file) {
            $tests[basename($file)] = [$file, dirname($file) . '/output/' . basename($file, '.php')];
        }
        return $tests;
    }

    private function normalize($str)
    {
        return preg_replace('/#\d+/', '#999', $str);
    }
}
