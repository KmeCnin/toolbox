<?php

namespace Mention\CoreBundle\Util;

/**
 * Class OptionalPattern
 *
 * This helper is useful in order to strip optionals characters from an input
 * string and keep only the string we want.
 *
 * For example we could have an input trying to match a twitter username from
 * url, like twitter.com/Foo, Foo/status or twitter.com/Foo/status.
 * But we only want to keep the username. So we define https://twitter.com/ as
 * the prefix before the username and /status/ as the suffix after the username.
 * After applying stripPrefix and stripSuffix, we can get the stripped result
 * which should be the username if the input was conform to twitter url pattern.
 *
 * @package Mention\CoreBundle\Util
 */
class OptionalPattern
{
    /**
     * @const int Minimal number of characters that must be matched in order to
     *            apply given prefix/suffix filter.
     */
    const DEFAULT_MIN_DIFF = 1;

    /** @var string */
    private $pattern;

    /**
     * @param $pattern
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * @param string $pattern
     * @return OptionalPattern
     */
    public static function fromPattern($pattern)
    {
        return new OptionalPattern($pattern);
    }

    /**
     * @param string $prefix
     * @param int    $minDiff
     * @return OptionalPattern
     */
    public function stripPrefix($prefix, $minDiff = self::DEFAULT_MIN_DIFF)
    {
        if ('' === $this->pattern) {
            return $this;
        }

        $strippedPattern = self::strip($this->pattern, $prefix);
        
        if (strlen($this->pattern) - strlen($strippedPattern) > $minDiff) {
            $this->pattern = $strippedPattern;
        }

        return $this;
    }

    /**
     * @param string $suffix
     * @param int    $minDiff
     * @return OptionalPattern
     */
    public function stripSuffix($suffix, $minDiff = self::DEFAULT_MIN_DIFF)
    {
        if ('' === $this->pattern) {
            return $this;
        }

        $strippedPattern = strrev(self::strip(
            strrev($this->pattern),
            strrev($suffix)
        ));

        if (strlen($this->pattern) - strlen($strippedPattern) > $minDiff) {
            $this->pattern = $strippedPattern;
        }

        return $this;
    }

    /**
     * @param string $pattern
     * @param string $fix
     * @return string
     */
    private static function strip($pattern, $fix)
    {
        for ($pos = 0, $len = strlen($fix); $pos < $len; $pos++) {
            if (0 === strpos($pattern, substr($fix, $pos))) {
                return substr($pattern, strlen($fix) - $pos) ?: '';
            }
        }
        return $pattern;
    }

    /**
     * @return string
     */
    public function getStripedPattern()
    {
        return $this->pattern;
    }
}
