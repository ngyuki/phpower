<?php
namespace ngyuki\Phpower;

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\AbstractDumper;
use Symfony\Component\VarDumper\Dumper\CliDumper;

class Reporter
{
    /**
     * @var VarCloner
     */
    private $cloner;

    /**
     * @var CliDumper
     */
    private $dumper;

    public function __construct()
    {
        $this->cloner = new VarCloner();
        $this->dumper = new CliDumper(null, null, AbstractDumper::DUMP_LIGHT_ARRAY | AbstractDumper::DUMP_TRAILING_COMMA);
    }

    public function report(array $statements)
    {
        if (!$statements) {
            return 'Assertion ok';
        }

        $last = array_pop($statements);

        $report = '';
        foreach ($statements as list($expression, $variable)) {
            $output = trim($this->dump($variable));
            if (strpos($output, "\n") === false) {
                $report .= "$expression -> $output\n";
            } else {
                $output = preg_replace('/^/m', '    ', $output);
                $output = ' -> ' . trim($output) . PHP_EOL;
                $report .= "$expression\n$output\n";
            }
        }
        $report = preg_replace('/^/m', '# ', $report);
        list($expression, $variable) = $last;
        $output = trim($this->dump($variable));
        if (strpos($output, "\n") === false) {
            return "Assertion failed $expression -> $output\n$report";
        } else {
            $output = preg_replace('/^/m', '     ', (string)$output);
            $output = '  -> ' . trim($output) . PHP_EOL;
            return "Assertion failed $expression\n$output\n$report";
        }
    }

    private function dump($variable): string
    {
        if (is_string($variable)) {
            return (string)json_encode($variable, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
        }
        return (string)$this->dumper->dump($this->cloner->cloneVar($variable), true);
    }
}
