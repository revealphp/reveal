<?php

declare (strict_types=1);
namespace RevealPrefix20220606\Reveal\TemplatePHPStanCompiler\NodeFactory;

use RevealPrefix20220606\PhpParser\Comment\Doc;
use RevealPrefix20220606\PhpParser\Node\Stmt\Nop;
use RevealPrefix20220606\Reveal\TemplatePHPStanCompiler\ValueObject\VariableAndType;
/**
 * @api
 */
final class VarDocNodeFactory
{
    /**
     * @param VariableAndType[] $variablesAndTypes
     * @return Nop[]
     */
    public function createDocNodes(array $variablesAndTypes) : array
    {
        $docNodes = [];
        foreach ($variablesAndTypes as $variableAndType) {
            $docNodes[$variableAndType->getVariable()] = $this->createDocNop($variableAndType);
        }
        return \array_values($docNodes);
    }
    private function createDocNop(VariableAndType $variableAndType) : Nop
    {
        $prependVarTypesDocBlocks = \sprintf('/** @var %s $%s */', $variableAndType->getTypeAsString(), $variableAndType->getVariable());
        // doc types node
        $docNop = new Nop();
        $docNop->setDocComment(new Doc($prependVarTypesDocBlocks));
        return $docNop;
    }
}
/**
 * @api
 */
\class_alias('RevealPrefix20220606\\Reveal\\TemplatePHPStanCompiler\\NodeFactory\\VarDocNodeFactory', 'Reveal\\TemplatePHPStanCompiler\\NodeFactory\\VarDocNodeFactory', \false);
