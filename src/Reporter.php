<?php
namespace ngyuki\Phpower;

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\AbstractDumper;
use Symfony\Component\VarDumper\Dumper\CliDumper;

class Reporter
{
    public function report(array $statements)
    {
        if (!$statements) {
            return 'Assertion ok';
        }

        $statements = array_reverse($statements);

        $report = '';
        foreach ($statements as list($expression, $variable)) {
            $report .= $expression . PHP_EOL;

            $cloner = new VarCloner();
            $dumper = new CliDumper(null, null, AbstractDumper::DUMP_LIGHT_ARRAY | AbstractDumper::DUMP_TRAILING_COMMA);
            $output = $dumper->dump($cloner->cloneVar($variable), true);
            $output = preg_replace('/^/m', '     ', (string)$output);
            $report .= '  -> ' . trim($output) . PHP_EOL;
        }
        $report = preg_replace('/^/m', '# ', $report);
        return "Assertion failed.\n$report";
    }
}
