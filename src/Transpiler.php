<?php
namespace ngyuki\Phpower;

use Microsoft\PhpParser\Node;

class Transpiler
{
    public function __invoke(string $source): string
    {
        $assert = 0;
        return (new NodeTraverser(function (Node $node, callable $next) use (&$assert) {
            $recorder = '\\' . Recorder::class;
            if ($argument = $this->fetchAssertArgumentExpression($node)) {
                $assert++;
                try {
                    return "$recorder::init()->expr({$next($argument)}), $recorder::dump()";
                } finally {
                    $assert--;
                }
            }
            if ($assert && $this->isCaptureNode($node)) {
                $expr = var_export($node->getText(), true);
                return "$recorder::cap($expr,{$next($node)})";
            }
            return $next($node);
        }))->traverse($source);
    }

    private function fetchAssertArgumentExpression(Node $node): ?Node
    {
        $parent = $node->parent;
        if ($parent instanceof Node\Expression\CallExpression === false) {
            return null;
        }
        /* @var Node\Expression\CallExpression $parent */
        if ($parent->callableExpression->getText() !== 'assert') {
            return null;
        }
        $argumentExpressionList = $parent->argumentExpressionList;
        if ($argumentExpressionList === null) {
            return null;
        }
        if ($argumentExpressionList !== $node) {
            return null;
        }
        if (count($argumentExpressionList->children) !== 1) {
            return null;
        }
        $argumentExpression = $argumentExpressionList->children[0];
        if ($argumentExpression instanceof Node === false) {
            return null;
        }
        return $argumentExpression;
    }

    private function isCaptureNode(Node $node)
    {
        if ($node instanceof Node\Expression === false) {
            return false;
        }
        if ($node instanceof Node\StringLiteral) {
            return false;
        }
        if ($node instanceof Node\NumericLiteral) {
            return false;
        }
        if ($node instanceof Node\Expression\ArrayCreationExpression) {
            return false;
        }
        if ($node instanceof Node\Expression\ArgumentExpression) {
            return false;
        }
        if ($node instanceof Node\Expression\ParenthesizedExpression) {
            return false;
        }
        return true;
    }
}
