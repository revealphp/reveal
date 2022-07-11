<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RevealPrefix20220711\Twig\Extension;

use RevealPrefix20220711\Twig\NodeVisitor\SandboxNodeVisitor;
use RevealPrefix20220711\Twig\Sandbox\SecurityNotAllowedMethodError;
use RevealPrefix20220711\Twig\Sandbox\SecurityNotAllowedPropertyError;
use RevealPrefix20220711\Twig\Sandbox\SecurityPolicyInterface;
use RevealPrefix20220711\Twig\Source;
use RevealPrefix20220711\Twig\TokenParser\SandboxTokenParser;
final class SandboxExtension extends AbstractExtension
{
    private $sandboxedGlobally;
    private $sandboxed;
    private $policy;
    public function __construct(SecurityPolicyInterface $policy, $sandboxed = \false)
    {
        $this->policy = $policy;
        $this->sandboxedGlobally = $sandboxed;
    }
    public function getTokenParsers() : array
    {
        return [new SandboxTokenParser()];
    }
    public function getNodeVisitors() : array
    {
        return [new SandboxNodeVisitor()];
    }
    public function enableSandbox() : void
    {
        $this->sandboxed = \true;
    }
    public function disableSandbox() : void
    {
        $this->sandboxed = \false;
    }
    public function isSandboxed() : bool
    {
        return $this->sandboxedGlobally || $this->sandboxed;
    }
    public function isSandboxedGlobally() : bool
    {
        return $this->sandboxedGlobally;
    }
    public function setSecurityPolicy(SecurityPolicyInterface $policy)
    {
        $this->policy = $policy;
    }
    public function getSecurityPolicy() : SecurityPolicyInterface
    {
        return $this->policy;
    }
    public function checkSecurity($tags, $filters, $functions) : void
    {
        if ($this->isSandboxed()) {
            $this->policy->checkSecurity($tags, $filters, $functions);
        }
    }
    public function checkMethodAllowed($obj, $method, int $lineno = -1, Source $source = null) : void
    {
        if ($this->isSandboxed()) {
            try {
                $this->policy->checkMethodAllowed($obj, $method);
            } catch (SecurityNotAllowedMethodError $e) {
                $e->setSourceContext($source);
                $e->setTemplateLine($lineno);
                throw $e;
            }
        }
    }
    public function checkPropertyAllowed($obj, $property, int $lineno = -1, Source $source = null) : void
    {
        if ($this->isSandboxed()) {
            try {
                $this->policy->checkPropertyAllowed($obj, $property);
            } catch (SecurityNotAllowedPropertyError $e) {
                $e->setSourceContext($source);
                $e->setTemplateLine($lineno);
                throw $e;
            }
        }
    }
    public function ensureToStringAllowed($obj, int $lineno = -1, Source $source = null)
    {
        if ($this->isSandboxed() && \is_object($obj) && \method_exists($obj, '__toString')) {
            try {
                $this->policy->checkMethodAllowed($obj, '__toString');
            } catch (SecurityNotAllowedMethodError $e) {
                $e->setSourceContext($source);
                $e->setTemplateLine($lineno);
                throw $e;
            }
        }
        return $obj;
    }
}
