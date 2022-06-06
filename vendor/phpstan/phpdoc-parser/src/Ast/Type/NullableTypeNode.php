<?php

declare (strict_types=1);
namespace RevealPrefix20220606\PHPStan\PhpDocParser\Ast\Type;

use RevealPrefix20220606\PHPStan\PhpDocParser\Ast\NodeAttributes;
class NullableTypeNode implements TypeNode
{
    use NodeAttributes;
    /** @var TypeNode */
    public $type;
    public function __construct(TypeNode $type)
    {
        $this->type = $type;
    }
    public function __toString() : string
    {
        return '?' . $this->type;
    }
}