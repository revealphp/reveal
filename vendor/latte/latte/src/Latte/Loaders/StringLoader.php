<?php

/**
 * This file is part of the Latte (https://latte.nette.org)
 * Copyright (c) 2008 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace RevealPrefix20220711\Latte\Loaders;

use RevealPrefix20220711\Latte;
/**
 * Template loader.
 */
class StringLoader implements Latte\Loader
{
    use Latte\Strict;
    /** @var string[]|null  [name => content] */
    private $templates;
    /**
     * @param  string[]  $templates
     */
    public function __construct(?array $templates = null)
    {
        $this->templates = $templates;
    }
    /**
     * Returns template source code.
     */
    public function getContent($name) : string
    {
        if ($this->templates === null) {
            return $name;
        } elseif (isset($this->templates[$name])) {
            return $this->templates[$name];
        } else {
            throw new Latte\RuntimeException("Missing template '{$name}'.");
        }
    }
    public function isExpired($name, $time) : bool
    {
        return \false;
    }
    /**
     * Returns referred template name.
     */
    public function getReferredName($name, $referringName) : string
    {
        if ($this->templates === null) {
            throw new \LogicException("Missing template '{$name}'.");
        }
        return $name;
    }
    /**
     * Returns unique identifier for caching.
     */
    public function getUniqueId($name) : string
    {
        return $this->getContent($name);
    }
}
