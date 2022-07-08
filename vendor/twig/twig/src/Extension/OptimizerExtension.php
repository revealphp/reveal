<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RevealPrefix20220708\Twig\Extension;

use RevealPrefix20220708\Twig\NodeVisitor\OptimizerNodeVisitor;
final class OptimizerExtension extends AbstractExtension
{
    private $optimizers;
    public function __construct(int $optimizers = -1)
    {
        $this->optimizers = $optimizers;
    }
    public function getNodeVisitors() : array
    {
        return [new OptimizerNodeVisitor($this->optimizers)];
    }
}
