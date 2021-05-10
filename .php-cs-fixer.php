<?php
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->path('src/')
    ->path('tests/')
    ->notPath('tests/cases')
;

return (new PhpCsFixer\Config())
    ->setFinder($finder)
    ->setRules([
        '@PSR2' => true,
    ])
;
