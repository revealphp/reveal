<?php

declare (strict_types=1);
namespace RevealPrefix20220606\Symplify\Astral\Naming;

use RevealPrefix20220606\Nette\Utils\Strings;
use RevealPrefix20220606\PhpParser\Node;
use RevealPrefix20220606\PhpParser\Node\Expr\ClassConstFetch;
use RevealPrefix20220606\PhpParser\Node\Expr\Variable;
use RevealPrefix20220606\PhpParser\Node\Stmt\ClassLike;
use RevealPrefix20220606\PhpParser\Node\Stmt\Property;
use RevealPrefix20220606\PHPStan\Analyser\Scope;
use RevealPrefix20220606\PHPStan\Reflection\ClassReflection;
use RevealPrefix20220606\Symplify\Astral\Contract\NodeNameResolverInterface;
/**
 * @see \Symplify\Astral\Tests\Naming\SimpleNameResolverTest
 */
final class SimpleNameResolver
{
    /**
     * @see https://regex101.com/r/ChpDsj/1
     * @var string
     */
    private const ANONYMOUS_CLASS_REGEX = '#^AnonymousClass[\\w+]#';
    /**
     * @var NodeNameResolverInterface[]
     */
    private $nodeNameResolvers;
    /**
     * @param NodeNameResolverInterface[] $nodeNameResolvers
     */
    public function __construct(array $nodeNameResolvers)
    {
        $this->nodeNameResolvers = $nodeNameResolvers;
    }
    /**
     * @param \PhpParser\Node|string $node
     */
    public function getName($node) : ?string
    {
        if (\is_string($node)) {
            return $node;
        }
        foreach ($this->nodeNameResolvers as $nodeNameResolver) {
            if (!$nodeNameResolver->match($node)) {
                continue;
            }
            return $nodeNameResolver->resolve($node);
        }
        if ($node instanceof ClassConstFetch && $this->isName($node->name, 'class')) {
            return $this->getName($node->class);
        }
        if ($node instanceof Property) {
            $propertyProperty = $node->props[0];
            return $this->getName($propertyProperty->name);
        }
        if ($node instanceof Variable) {
            return $this->getName($node->name);
        }
        return null;
    }
    /**
     * @param string[] $desiredNames
     */
    public function isNames(Node $node, array $desiredNames) : bool
    {
        foreach ($desiredNames as $desiredName) {
            if ($this->isName($node, $desiredName)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param string|\PhpParser\Node $node
     */
    public function isName($node, string $desiredName) : bool
    {
        $name = $this->getName($node);
        if ($name === null) {
            return \false;
        }
        if (\strpos($desiredName, '*') !== \false) {
            return \fnmatch($desiredName, $name);
        }
        return $name === $desiredName;
    }
    public function areNamesEqual(Node $firstNode, Node $secondNode) : bool
    {
        $firstName = $this->getName($firstNode);
        if ($firstName === null) {
            return \false;
        }
        return $this->isName($secondNode, $firstName);
    }
    public function resolveShortNameFromNode(ClassLike $classLike) : ?string
    {
        $className = $this->getName($classLike);
        if ($className === null) {
            return null;
        }
        // anonymous class return null name
        if (Strings::match($className, self::ANONYMOUS_CLASS_REGEX)) {
            return null;
        }
        return $this->resolveShortName($className);
    }
    public function resolveShortNameFromScope(Scope $scope) : ?string
    {
        $className = $this->getClassNameFromScope($scope);
        if ($className === null) {
            return null;
        }
        return $this->resolveShortName($className);
    }
    public function getClassNameFromScope(Scope $scope) : ?string
    {
        if ($scope->isInTrait()) {
            $traitReflection = $scope->getTraitReflection();
            if (!$traitReflection instanceof ClassReflection) {
                return null;
            }
            return $traitReflection->getName();
        }
        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof ClassReflection) {
            return null;
        }
        return $classReflection->getName();
    }
    public function isNameMatch(Node $node, string $desiredNameRegex) : bool
    {
        $name = $this->getName($node);
        if ($name === null) {
            return \false;
        }
        return (bool) Strings::match($name, $desiredNameRegex);
    }
    public function resolveShortName(string $className) : string
    {
        if (\strpos($className, '\\') === \false) {
            return $className;
        }
        return (string) Strings::after($className, '\\', -1);
    }
}