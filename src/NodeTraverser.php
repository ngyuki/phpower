<?php
declare(strict_types=1);

namespace ngyuki\Phpower;

use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Parser;
use Microsoft\PhpParser\Token;

class NodeTraverser
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @var callable
     */
    private $next;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
        $this->next = function (Node $node) {
            return $this->next($node);
        };
    }

    public function traverse(string $source): string
    {
        $ast = (new Parser())->parseSourceFile($source);
        return $this->recursive($ast);
    }

    private function next(Node $node): string
    {
        $output = '';
        foreach ($node->getChildNodesAndTokens() as $child) {
            if ($child instanceof Node) {
                $output .= $this->recursive($child);
            } elseif ($child instanceof Token) {
                $output .= $child->getFullText($node->getFileContents());
            }
        }
        return $output;
    }

    private function recursive(Node $node): string
    {
        return ($this->callback)($node, $this->next);
    }
}
