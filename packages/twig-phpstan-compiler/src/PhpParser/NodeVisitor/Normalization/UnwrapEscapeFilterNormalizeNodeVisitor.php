<?php

declare (strict_types=1);
namespace RevealPrefix20220606\Reveal\TwigPHPStanCompiler\PhpParser\NodeVisitor\Normalization;

use RevealPrefix20220606\PhpParser\Node;
use RevealPrefix20220606\PhpParser\Node\Expr\FuncCall;
use RevealPrefix20220606\PhpParser\NodeVisitorAbstract;
use RevealPrefix20220606\Reveal\TwigPHPStanCompiler\Contract\NodeVisitor\NormalizingNodeVisitorInterface;
use RevealPrefix20220606\Symplify\Astral\Naming\SimpleNameResolver;
final class UnwrapEscapeFilterNormalizeNodeVisitor extends NodeVisitorAbstract implements NormalizingNodeVisitorInterface
{
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    public function __construct(SimpleNameResolver $simpleNameResolver)
    {
        $this->simpleNameResolver = $simpleNameResolver;
    }
    public function enterNode(Node $node)
    {
        if (!$node instanceof FuncCall) {
            return null;
        }
        if (!$this->simpleNameResolver->isName($node->name, 'twig_escape_filter')) {
            return null;
        }
        return $node->getArgs()[1]->value;
    }
}