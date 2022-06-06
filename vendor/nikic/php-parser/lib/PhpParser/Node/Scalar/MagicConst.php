<?php

declare (strict_types=1);
namespace RevealPrefix20220606\PhpParser\Node\Scalar;

use RevealPrefix20220606\PhpParser\Node\Scalar;
abstract class MagicConst extends Scalar
{
    /**
     * Constructs a magic constant node.
     *
     * @param array $attributes Additional attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }
    public function getSubNodeNames() : array
    {
        return [];
    }
    /**
     * Get name of magic constant.
     *
     * @return string Name of magic constant
     */
    public abstract function getName() : string;
}
\class_alias('RevealPrefix20220606\\PhpParser\\Node\\Scalar\\MagicConst', 'PhpParser\\Node\\Scalar\\MagicConst', \false);
