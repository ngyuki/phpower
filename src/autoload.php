<?php declare(strict_types=1);
namespace ngyuki\Phpower;

use Microsoft\PhpParser\Node;
use PHPUnit\Util\Filesystem;
use ReflectionClass;

StreamFilter::register();

if (class_exists(Filesystem::class, true)) {
    // @phan-suppress-next-line PhanPossiblyFalseTypeArgumentInternal
    $dir = dirname((new ReflectionClass(Filesystem::class))->getFileName());

    StreamFilter::load($dir . DIRECTORY_SEPARATOR . '/FileLoader.php', function (string $source) {
        return (new NodeTraverser(function (Node $node, callable $next) {
            if ($node instanceof Node\Expression\ScriptInclusionExpression) {
                return $node->requireOrIncludeKeyword->getLeadingCommentsAndWhitespaceText($node->getFileContents())
                    . '\\' . StreamFilter::class . '::load(' . $next($node->expression) . ', new \\' . Transpiler::class . '())';
            }
            return $next($node);
        }))->traverse($source);
    });
}
