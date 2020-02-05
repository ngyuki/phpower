<?php
declare(strict_types=1);

namespace ngyuki\Phpower;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Token;
use PHPUnit\Framework\Assert;
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
         // Node\Expression\MemberAccessExpression::class => true,
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

    private $assert = 0;

    private $debug = false;

    public function withDebug(): self
    {
        $clone = clone $this;
        $clone->debug = true;
        return $clone;
    }

    public function __invoke(string $source): string
    {
        $this->assert = 0;
        return (new NodeTraverser(function (Node $node, callable $next) {
            if ($node instanceof Node\Expression\CallExpression) {
                $output = $this->processAssertCallExpression($node, $next);
                if (is_string($output)) {
                    return $output;
                }
            }
            if (!$this->assert) {
                return $next($node);
            }
            if ($this->debug) {
                echo str_repeat('    ', $this->assert) . ($this->isCaptureNode($node)  ? '@' : ' ').
                    get_class($node) . ' ' . $node->getText() . PHP_EOL;
            }

            $this->assert++;
            try {
                if ($this->isCaptureNode($node)) {
                    $recorder = '\\' . Recorder::class;
                    $expr = var_export($this->prettyExpression($node), true);
                    return "$recorder::cap($expr,{$next($node)})";
                }
                return $next($node);
            } finally {
                $this->assert--;
            }
        }))->traverse($source);
    }

    private function processAssertCallExpression(Node\Expression\CallExpression $node, callable $next): ?string
    {
        if ($node->callableExpression->getText() !== 'assert') {
            return null;
        }
        $argumentList = $node->argumentExpressionList;
        if ($argumentList === null) {
            return null;
        }
        if (count($argumentList->children) !== 1) {
            return null;
        }
        $argument = $argumentList->children[0];
        if ($argument instanceof Node === false) {
            return null;
        }
        $recorder = '\\' . Recorder::class;
        $assert = '\\' . Assert::class;
        $this->assert++;
        try {
            return $node->callableExpression->getLeadingCommentAndWhitespaceText()
                . $node->openParen->getFullText($node->getFileContents())
                . "$recorder::init()->expr({$next($argument)}) ? $assert::assertTrue(true) : $assert::fail($recorder::dump())"
                . $node->closeParen->getFullText($node->getFileContents());
        } finally {
            $this->assert--;
        }
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
        if ($node instanceof Node\Expression\Variable) {
            if ($node->parent instanceof Node\Expression\PrefixUpdateExpression) {
                // ++$i
                return false;
            }
            if ($node->parent instanceof Node\Expression\PostfixUpdateExpression) {
                // $i++
                return false;
            }
        }
        for ($parent = $node->parent; $parent; $parent = $parent->parent) {
            if ($parent instanceof Node\Expression\IssetIntrinsicExpression) {
                // isset()
                return false;
            }
            if ($parent instanceof Node\Expression\ScopedPropertyAccessExpression) {
                // Class::$v
                // Class::f()
                return false;
            }
        }
        if ($node instanceof Node\Expression\ScopedPropertyAccessExpression) {
            if ($node->parent instanceof Node\Expression\CallExpression) {
                // Class::f()
                return false;
            }
        }
        foreach ($classes as $class) {
            if ($this->captureNodeClasses[$class] ?? false) {
                return true;
            }
        }
        if ($node instanceof Node\Expression\MemberAccessExpression) {
            if ($node->parent instanceof Node\Expression\CallExpression === false) {
                // object property
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
