<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RevealPrefix20220606\Twig\Node\Expression;

use RevealPrefix20220606\Twig\Compiler;
class TempNameExpression extends AbstractExpression
{
    public function __construct(string $name, int $lineno)
    {
        parent::__construct([], ['name' => $name], $lineno);
    }
    public function compile(Compiler $compiler) : void
    {
        $compiler->raw('$_')->raw($this->getAttribute('name'))->raw('_');
    }
}