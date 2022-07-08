<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RevealPrefix20220708\Twig\Node\Expression\Binary;

use RevealPrefix20220708\Twig\Compiler;
class GreaterBinary extends AbstractBinary
{
    public function compile(Compiler $compiler) : void
    {
        if (\PHP_VERSION_ID >= 80000) {
            parent::compile($compiler);
            return;
        }
        $compiler->raw('(1 === twig_compare(')->subcompile($this->getNode('left'))->raw(', ')->subcompile($this->getNode('right'))->raw('))');
    }
    public function operator(Compiler $compiler) : Compiler
    {
        return $compiler->raw('>');
    }
}
