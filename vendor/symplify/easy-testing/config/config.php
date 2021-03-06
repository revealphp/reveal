<?php

declare (strict_types=1);
namespace RevealPrefix20220713;

use RevealPrefix20220713\Symfony\Component\Console\Application;
use RevealPrefix20220713\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RevealPrefix20220713\Symplify\EasyTesting\Command\ValidateFixtureSkipNamingCommand;
use function RevealPrefix20220713\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire();
    $services->load('RevealPrefix20220713\Symplify\\EasyTesting\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/DataProvider', __DIR__ . '/../src/Kernel', __DIR__ . '/../src/ValueObject']);
    // console
    $services->set(Application::class)->call('add', [service(ValidateFixtureSkipNamingCommand::class)]);
};
