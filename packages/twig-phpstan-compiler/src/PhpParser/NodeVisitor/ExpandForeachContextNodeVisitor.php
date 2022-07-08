<?php

declare (strict_types=1);
namespace Reveal\TwigPHPStanCompiler\PhpParser\NodeVisitor;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use RevealPrefix20220708\Symplify\Astral\Naming\SimpleNameResolver;
/**
 * Inlined magic assign, to explicit variable $context['_seq'] = $items ?? \null; ↓ $items
 */
final class ExpandForeachContextNodeVisitor extends NodeVisitorAbstract
{
    /**
     * @var string|null
     */
    private $activeVariableName = null;
    /**
     * @var \PhpParser\Node\Stmt\Expression|null
     */
    private $expressionToRemove = null;
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
        if ($node instanceof Expression) {
            $this->refactorExpression($node);
            return null;
        }
        if ($node instanceof Foreach_) {
            return $this->refactorForeach($node);
        }
        return null;
    }
    public function leaveNode(Node $node)
    {
        if (!$node instanceof Expression) {
            return null;
        }
        if ($this->expressionToRemove !== $node) {
            return null;
        }
        // reset
        $this->expressionToRemove = null;
        return NodeTraverser::REMOVE_NODE;
    }
    private function isArrayDimFetchWithKey(Expr $expr, string $desiredKey) : bool
    {
        if (!$expr instanceof ArrayDimFetch) {
            return \false;
        }
        if (!$expr->dim instanceof String_) {
            return \false;
        }
        $string = $expr->dim;
        return $string->value === $desiredKey;
    }
    private function refactorExpression(Expression $expression) : void
    {
        $expr = $expression->expr;
        if (!$expr instanceof Assign) {
            return;
        }
        if (!$this->isArrayDimFetchWithKey($expr->var, '_seq')) {
            return;
        }
        if (!$expr->expr instanceof Variable) {
            return;
        }
        $variableName = $this->simpleNameResolver->getName($expr->expr);
        $this->activeVariableName = $variableName;
        $this->expressionToRemove = $expression;
    }
    /**
     * @return null|\PhpParser\Node\Stmt\Foreach_
     */
    private function refactorForeach(Foreach_ $foreach)
    {
        if ($this->activeVariableName === null) {
            return null;
        }
        // replace dim fetch with variable
        if (!$this->isArrayDimFetchWithKey($foreach->expr, '_seq')) {
            return null;
        }
        $foreach->expr = new Variable($this->activeVariableName);
        return $foreach;
    }
}
