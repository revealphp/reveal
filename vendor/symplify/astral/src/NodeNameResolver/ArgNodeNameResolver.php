<?php

declare (strict_types=1);
namespace RevealPrefix20220713\Symplify\Astral\NodeNameResolver;

use PhpParser\Node;
use PhpParser\Node\Arg;
use RevealPrefix20220713\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ArgNodeNameResolver implements NodeNameResolverInterface
{
    public function match(Node $node) : bool
    {
        return $node instanceof Arg;
    }
    /**
     * @param Arg $node
     */
    public function resolve(Node $node) : ?string
    {
        if ($node->name === null) {
            return null;
        }
        return (string) $node->name;
    }
}
