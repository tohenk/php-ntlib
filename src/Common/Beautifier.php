<?php

/*
 * The MIT License
 *
 * Copyright (c) 2014-2026 Toha <tohenk@yahoo.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
 * of the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace NTLAB\Lib\Common;

/**
 * String beautifier which can ignores list or roman number.
 *
 * @author Toha <tohenk@yahoo.com>
 */
class Beautifier
{
    public const IGNORE_NONE = 0x00;
    public const IGNORE_INLIST = 0x01;
    public const IGNORE_ROMAN = 0x02;
    public const IGNORE_ADDRESS = 0x04;
    public const IGNORE_ABBREVIATION = 0x08;
    public const ROMAN_TOUPPER = 0x10;
    public const ADDRESS_TOUPPER = 0x20;
    public const ABBREVIATION_TOUPPER = 0x40;

    /** @var int */
    protected $flags = self::IGNORE_NONE;

    /** @var string */
    protected $delimeters = ' /-()';

    /** @var string[] */
    protected $ignores = [];

    /** @var string[] */
    protected $addresses = ['blok', 'nomor', 'no'];

    /** @var string */
    protected $addressDelimeters = '/-';

    /**
     * Get instance.
     *
     * @return \NTLAB\Lib\Common\Beautifier
     */
    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Do the beauty.
     *
     * @param string $str  The text to beautify
     * @param int $flags  Ignores flag
     * @return string
     */
    public static function beautify($str, $flags = null)
    {
        return static::getInstance()
            ->doBeautify($str, $flags);
    }

    /**
     * Load ignored texts.
     *
     * @param string $filename  Filename
     * @return bool true if loaded
     */
    public function loadIgnores($filename)
    {
        if (is_readable($filename)) {
            $this->addIgnore(file($filename));

            return true;
        }

        return false;
    }

    /**
     * Add ignored text which the case is stay unchanged.
     *
     * @param array $array  The ignored text
     * @return \NTLAB\Lib\Common\Beautifier
     */
    public function addIgnore($array = [])
    {
        if (null !== $array && false !== $array) {
            if (!is_array($array)) {
                $array = [$array];
            }
            foreach ($array as $a) {
                $a = trim($a);
                if (!in_array($a, $this->ignores)) {
                    $this->ignores[] = $a;
                }
            }
        }

        return $this;
    }

    /**
     * Set default ignores flag.
     *
     * @param int $flags Ignores flag
     * @return \NTLAB\Lib\Common\Beautifier
     */
    public function setFlags($flags)
    {
        $this->flags = $flags;

        return $this;
    }

    /**
     * Get ignored text.
     *
     * @param string $str  The text
     * @return string
     */
    protected function getIgnored($str)
    {
        foreach ($this->ignores as $ignored) {
            if (strtolower($str) === strtolower($ignored)) {
                return $ignored;
            }
        }
    }

    /**
     * Check if input is a delimeter.
     *
     * @param string $char
     * @return bool
     */
    protected function isDelimeter($char)
    {
        if (false !== strpos($this->delimeters, $char)) {
            return true;
        }

        return false;
    }

    /**
     * Is string an address prefix?
     *
     * @param string $str Address string
     * @return bool
     */
    protected function isAddreses($str)
    {
        $str = strtolower((string) $str);
        if ('.' === substr($str, -1)) {
            $str = substr($str, 0, -1);
        }

        return in_array($str, $this->addresses);
    }

    /**
     * Is string an encloser?
     *
     * @param string $opening Opening parenthesis
     * @param string $closing Closing parenthesis
     * @return bool
     */
    protected function isEnclosed($opening, $closing)
    {
        return implode([$opening, $closing]) === '()';
    }

    /**
     * Extract string based on delimeter.
     *
     * @param string $str
     * @return string
     */
    public function extract($str)
    {
        $i = 0;
        $pos = null;
        while (true) {
            if ($this->isDelimeter($str[$i])) {
                $pos = $i;
                if ($pos > 0 || $i === strlen($str) - 1) {
                    break;
                }
            } else {
                if ($i === strlen($str) - 1) {
                    break;
                }
            }
            $i++;
        }
        if ($pos === null) {
            $pos = strlen($str);
        }

        return substr($str, 0, $pos);
    }

    /**
     * Beautify a word.
     *
     * @param string $str  The text to beautify
     * @return string
     */
    public function beautifyWord($str)
    {
        $str = strtolower($str);
        for ($i = 0; $i < strlen($str); $i++) {
            if (!$this->isDelimeter($str[$i])) {
                $str[$i] = strtoupper($str[$i]);
                break;
            }
        }

        return $str;
    }

    /**
     * Do beautify.
     *
     * @param string $str  The text to beautify
     * @param int $flags  Ignores flag
     * @return string
     */
    public function doBeautify($str, $flags = null)
    {
        $result = null;
        if (null === $flags) {
            $flags = $this->flags;
        }
        $whitelist = ($flags & static::IGNORE_INLIST) === static::IGNORE_INLIST;
        $addresses = ($flags & static::IGNORE_ADDRESS) === static::IGNORE_ADDRESS;
        $roman = ($flags & static::IGNORE_ROMAN) === static::IGNORE_ROMAN;
        $abbvr = ($flags & static::IGNORE_ABBREVIATION) === static::IGNORE_ABBREVIATION;
        $addressesToUpper = ($flags & static::ADDRESS_TOUPPER) === static::ADDRESS_TOUPPER;
        $romanToUpper = ($flags & static::ROMAN_TOUPPER) === static::ROMAN_TOUPPER;
        $abbvrToUpper = ($flags & static::ABBREVIATION_TOUPPER) === static::ABBREVIATION_TOUPPER;
        $prev = $delim = null;
        $str = (string) $str;
        while (true) {
            if (0 === strlen(trim($str))) {
                break;
            }
            $word = $beautified = $this->extract($str);
            $pos = strpos($str, $word);
            $next = $pos + strlen($word) + 1;
            switch (true) {
                case $roman && is_int(Roman::asInteger($word)):
                    if ($romanToUpper) {
                        $beautified = strtoupper($word);
                    }
                    break;
                case $addresses && $this->isAddreses($prev):
                    if ($addressesToUpper) {
                        $beautified = strtoupper($word);
                    }
                    break;
                case $abbvr && $this->isEnclosed(substr($str, $pos, 1), substr($str, $next - 1, 1)):
                    if ($abbvrToUpper) {
                        $beautified = strtoupper($word);
                    }
                    break;
                case $whitelist && null !== ($ignored = $this->getIgnored($word)):
                    $beautified = $ignored;
                    break;
                default:
                    $beautified = $this->beautifyWord($word);
            }
            if ($next >= strlen($str)) {
                $next = strlen($str);
            }
            $tmp = substr($str, 0, $next);
            if ($word != $beautified) {
                $tmp = str_replace($word, $beautified, $tmp);
            }
            $result .= $tmp;
            if ($next === strlen($str)) {
                break;
            }
            $delim = substr($str, $next - 1, 1);
            switch (true) {
                case $addresses && $this->isAddreses($prev) && false !== strpos($this->addressDelimeters, $delim):
                    break;
                default:
                    $prev = $word;
            }
            $str = substr($str, $next);
        }

        return $result;
    }
}