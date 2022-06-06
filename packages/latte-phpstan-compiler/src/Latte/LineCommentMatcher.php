<?php

declare (strict_types=1);
namespace RevealPrefix20220606\Reveal\LattePHPStanCompiler\Latte;

use RevealPrefix20220606\Nette\Utils\Strings;
/**
 * @see \Reveal\LattePHPStanCompiler\Tests\Latte\LineCommentMatcherTest
 */
final class LineCommentMatcher
{
    /**
     * @var string
     * @see https://regex101.com/r/Qb4cuo/1
     */
    private const COMMENTED_LINE_NUMBER_REGEX = '#\\/\\* line (?<' . self::NUMBER_KEY . '>\\d+) \\*\\/#';
    /**
     * @var string
     * @see https://regex101.com/r/eFkTOK/1
     */
    private const CORRECTED_COMMENTED_LINE_NUMBER_REGEX = '#\\*\\* line in latte file: (?<number>\\d+) \\*\\/#';
    /**
     * @var string
     */
    private const NUMBER_KEY = 'number';
    /**
     * @return int|null
     */
    public function matchLine(string $content)
    {
        // native latte position
        $match = Strings::match($content, self::COMMENTED_LINE_NUMBER_REGEX);
        if (isset($match[self::NUMBER_KEY])) {
            return (int) $match[self::NUMBER_KEY];
        }
        // corrected latte position
        $correctedMatch = Strings::match($content, self::CORRECTED_COMMENTED_LINE_NUMBER_REGEX);
        if (isset($correctedMatch[self::NUMBER_KEY])) {
            return (int) $correctedMatch[self::NUMBER_KEY];
        }
        return null;
    }
}