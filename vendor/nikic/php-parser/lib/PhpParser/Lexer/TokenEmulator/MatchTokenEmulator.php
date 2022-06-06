<?php

declare (strict_types=1);
namespace RevealPrefix20220606\PhpParser\Lexer\TokenEmulator;

use RevealPrefix20220606\PhpParser\Lexer\Emulative;
final class MatchTokenEmulator extends KeywordEmulator
{
    public function getPhpVersion() : string
    {
        return Emulative::PHP_8_0;
    }
    public function getKeywordString() : string
    {
        return 'match';
    }
    public function getKeywordToken() : int
    {
        return \T_MATCH;
    }
}
\class_alias('RevealPrefix20220606\\PhpParser\\Lexer\\TokenEmulator\\MatchTokenEmulator', 'PhpParser\\Lexer\\TokenEmulator\\MatchTokenEmulator', \false);
