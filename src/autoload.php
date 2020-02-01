<?php declare(strict_types=1);
namespace ngyuki\Phpower;

use Microsoft\PhpParser\Node;
use PHPUnit\Util\Filesystem;
use ReflectionClass;
use Throwable;

try {
    // @phan-suppress-next-line PhanPossiblyFalseTypeArgumentInternal
    $dir = dirname((new ReflectionClass(Filesystem::class))->getFileName());

    Loader::load($dir . DIRECTORY_SEPARATOR . '/FileLoader.php', function (string $source) {
        return (new NodeTraverser(function (Node $node, callable $next) {
            if ($node instanceof Node\Expression\ScriptInclusionExpression) {
                return $node->requireOrIncludeKeyword->getLeadingCommentsAndWhitespaceText($node->getFileContents())
                    . '\\' . Loader::class . '::load(' . $next($node->expression) . ', new \\' . Transpiler::class . '())';
            }

            return null;
        }))->traverse($source);
    });
} catch (Throwable $ex) {
    // pass
}
