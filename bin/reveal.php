<?php

declare (strict_types=1);
namespace RevealPrefix20220713;

use Reveal\Kernel\RevealKernel;
use RevealPrefix20220713\Symplify\SymplifyKernel\ValueObject\KernelBootAndApplicationRun;
require __DIR__ . '/../vendor/autoload.php';
// scoper autoload
$scoperAutoloadFile = __DIR__ . '/../vendor/scoper-autoload.php';
if ($scoperAutoloadFile) {
    require_once $scoperAutoloadFile;
}
$kernelBootAndApplicationRun = new KernelBootAndApplicationRun(RevealKernel::class);
$kernelBootAndApplicationRun->run();
