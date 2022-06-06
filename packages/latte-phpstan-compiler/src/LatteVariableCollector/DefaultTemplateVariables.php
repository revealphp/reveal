<?php

declare (strict_types=1);
namespace RevealPrefix20220606\Reveal\LattePHPStanCompiler\LatteVariableCollector;

use RevealPrefix20220606\PHPStan\Type\ArrayType;
use RevealPrefix20220606\PHPStan\Type\MixedType;
use RevealPrefix20220606\PHPStan\Type\ObjectType;
use RevealPrefix20220606\PHPStan\Type\StringType;
use RevealPrefix20220606\Reveal\LattePHPStanCompiler\Contract\LatteVariableCollectorInterface;
use RevealPrefix20220606\Reveal\TemplatePHPStanCompiler\ValueObject\VariableAndType;
use stdClass;
final class DefaultTemplateVariables implements LatteVariableCollectorInterface
{
    /**
     * @return VariableAndType[]
     */
    public function getVariablesAndTypes() : array
    {
        $variablesAndTypes = [];
        $variablesAndTypes[] = new VariableAndType('baseUrl', new StringType());
        $variablesAndTypes[] = new VariableAndType('basePath', new StringType());
        $variablesAndTypes[] = new VariableAndType('ʟ_fi', new ObjectType('RevealPrefix20220606\\Latte\\Runtime\\FilterInfo'));
        // nette\security bridge
        $variablesAndTypes[] = new VariableAndType('user', new ObjectType('RevealPrefix20220606\\Nette\\Security\\User'));
        // nette\application bridge
        $variablesAndTypes[] = new VariableAndType('presenter', new ObjectType('RevealPrefix20220606\\Nette\\Application\\UI\\Presenter'));
        $variablesAndTypes[] = new VariableAndType('control', new ObjectType('RevealPrefix20220606\\Nette\\Application\\UI\\Control'));
        $flashesArrayType = new ArrayType(new MixedType(), new ObjectType(stdClass::class));
        $variablesAndTypes[] = new VariableAndType('flashes', $flashesArrayType);
        return $variablesAndTypes;
    }
}
\class_alias('RevealPrefix20220606\\Reveal\\LattePHPStanCompiler\\LatteVariableCollector\\DefaultTemplateVariables', 'Reveal\\LattePHPStanCompiler\\LatteVariableCollector\\DefaultTemplateVariables', \false);
