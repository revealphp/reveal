<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RevealPrefix20220708\Twig\Node\Expression\Test;

use RevealPrefix20220708\Twig\Compiler;
use RevealPrefix20220708\Twig\Node\Expression\TestExpression;
/**
 * Checks if a number is odd.
 *
 *  {{ var is odd }}
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class OddTest extends TestExpression
{
    public function compile(Compiler $compiler) : void
    {
        $compiler->raw('(')->subcompile($this->getNode('node'))->raw(' % 2 != 0')->raw(')');
    }
}
