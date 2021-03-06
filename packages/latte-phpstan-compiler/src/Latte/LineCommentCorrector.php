<?php

declare (strict_types=1);
namespace Reveal\LattePHPStanCompiler\Latte;

final class LineCommentCorrector
{
    /**
     * @var \Reveal\LattePHPStanCompiler\Latte\LineCommentMatcher
     */
    private $lineCommentMatcher;
    public function __construct(\Reveal\LattePHPStanCompiler\Latte\LineCommentMatcher $lineCommentMatcher)
    {
        $this->lineCommentMatcher = $lineCommentMatcher;
    }
    /**
     * Move line comments above the line, otherwise php-parser loses them on parsing
     */
    public function correctLineNumberPosition(string $phpContent) : string
    {
        $phpContentLines = \explode(\PHP_EOL, $phpContent);
        $correctedPhpContent = '';
        foreach ($phpContentLines as $phpContentLine) {
            $lineNumber = $this->lineCommentMatcher->matchLine($phpContentLine);
            if ($lineNumber === null) {
                $correctedPhpContent .= $phpContentLine . \PHP_EOL;
                continue;
            }
            $correctedPhpContent .= '/** line in latte file: ' . $lineNumber . ' */ ' . \PHP_EOL;
            $correctedPhpContent .= $phpContentLine;
        }
        return $correctedPhpContent;
    }
}
