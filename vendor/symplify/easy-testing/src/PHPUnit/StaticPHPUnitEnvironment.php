<?php

declare (strict_types=1);
namespace RevealPrefix20220713\Symplify\EasyTesting\PHPUnit;

/**
 * @api
 */
final class StaticPHPUnitEnvironment
{
    /**
     * Never ever used static methods if not neccesary, this is just handy for tests + src to prevent duplication.
     */
    public static function isPHPUnitRun() : bool
    {
        return \defined('RevealPrefix20220713\\PHPUNIT_COMPOSER_INSTALL') || \defined('RevealPrefix20220713\\__PHPUNIT_PHAR__');
    }
}
