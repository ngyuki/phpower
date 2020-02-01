<?php declare(strict_types=1);
namespace ngyuki\Phpower;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Token;
use ReflectionClass;

class Transpiler
{
    private $captureNodeClasses = [
         // Node\Expression\AnonymousFunctionCreationExpression::class => true,
         // Node\Expression\ArgumentExpression::class => true,
         // Node\Expression\ArrayCreationExpression::class => true,
         Node\Expression\ArrowFunctionCreationExpression::class => true,
         Node\Expression\BinaryExpression::class => true,
         Node\Expression\AssignmentExpression::class => true,
         // Node\Expression\BracedExpression::class => true,
         Node\Expression\CallExpression::class => true,
         Node\Expression\CastExpression::class => true,
         // Node\Expression\ErrorControlExpression::class => true,
         Node\Expression\PrefixUpdateExpression::class => true,
         // Node\Expression\UnaryOpExpression::class => true,
         // Node\Expression\CloneExpression::class => true,
         // Node\Expression\EchoExpression::class => true,
         Node\Expression\EmptyIntrinsicExpression::class => true,
         Node\Expression\EvalIntrinsicExpression::class => true,
         // Node\Expression\ExitIntrinsicExpression::class => true,
         Node\Expression\IssetIntrinsicExpression::class => true,
         // Node\Expression\ListIntrinsicExpression::class => true,
         Node\Expression\MemberAccessExpression::class => true,
         Node\Expression\ObjectCreationExpression::class => true,
         // Node\Expression\ParenthesizedExpression::class => true,
         Node\Expression\PostfixUpdateExpression::class => true,
         // Node\Expression\PrintIntrinsicExpression::class => true,
         Node\Expression\ScopedPropertyAccessExpression::class => true,
         Node\Expression\ScriptInclusionExpression::class => true,
         Node\Expression\SubscriptExpression::class => true,
         Node\Expression\TernaryExpression::class => true,
         // Node\Expression\UnsetIntrinsicExpression::class => true,
         Node\Expression\Variable::class => true,
         // Node\Expression\YieldExpression::class => true,
         // Node\NumericLiteral::class => true,
         // Node\ReservedWord::class => true,
         // Node\StringLiteral::class => true,
    ];

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
                $expr = var_export($this->prettyExpression($node), true);
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
        $classes = [];
        for ($r = new ReflectionClass($node); $r; $r = $r->getParentClass()) {
            $classes[] = $r->getName();
        }
        foreach ($classes as $class) {
            if ($this->captureNodeClasses[$class] ?? false) {
                return true;
            }
        }
        return false;
    }

    private function prettyExpression(Node $node): string
    {
        $arr = [];
        foreach ($node->getChildNodesAndTokens() as $child) {
            if ($child instanceof Node) {
                $arr[] = $this->prettyExpression($child);
            } elseif ($child instanceof Token) {
                $arr[] = $child->getText($node->getFileContents());
            }
        }
        $delimiter = '';
        if ($node instanceof Node\Expression\BinaryExpression) {
            $delimiter = ' ';
        }
        if ($node instanceof Node\Expression\TernaryExpression) {
            $delimiter = ' ';
        }
        return implode($delimiter, $arr);
    }
}
