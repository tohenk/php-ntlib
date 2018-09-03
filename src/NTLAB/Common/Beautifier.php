<?php

/*
 * The MIT License
 *
 * Copyright (c) 2014 Toha <tohenk@yahoo.com>
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

namespace NTLAB\Common;

class Beautifier
{
    const IGNORE_NONE = 0;
    const IGNORE_ROMAN = 1;
    const IGNORE_INLIST = 2;

    protected static $delimeters = ' /-()';
    protected static $ignores = array();

    /**
     * Load ignored texts.
     *
     * @param string $filename  Filename
     * @return boolean true if loaded
     */
    public static function loadIgnores($filename)
    {
        if (is_readable($filename)) {
            self::addIgnore(file($filename));

            return true;
        }

        return false;
    }

    /**
     * Add ignored text which the case is stay unchanged.
     *
     * @param array $array  The ignored text
     */
    public static function addIgnore($array = array())
    {
        if (null === $array || false === $array) {
            return;
        }
        if (!is_array($array)) {
            $array = array($array);
        }
        foreach ($array as $a) {
            $a = trim($a);
            if (!in_array($a, static::$ignores)) {
                static::$ignores[] = $a;
            }
        }
    }

    /**
     * Get ignored text.
     *
     * @param string $str  The text
     * @return string
     */
    protected static function getIgnored($str)
    {
        foreach (static::$ignores as $ignored) {
            if (strtolower($str) == strtolower($ignored)) {
                return $ignored;
            }
        }
    }

    /**
     * Check if input is a delimeter.
     *
     * @param string $char
     * @return boolean
     */
    protected static function isDelimeter($char)
    {
        if (false !== strpos(static::$delimeters, $char)) {
            return true;
        }

        return false;
    }

    /**
     * Extract string based on delimeter.
     *
     * @param string $str
     * @return string
     */
    protected static function extract($str)
    {
        $i = 0;
        $pos = null;
        while (true) {
            if (self::isDelimeter($str[$i])) {
                $pos = $i;
                if ($pos > 0 || $i == strlen($str) - 1) {
                    break;
                }
            } else {
                if ($i == strlen($str) - 1) {
                    break;
                }
            }
            $i++;
        }
        if ($pos == null) {
            $pos = strlen($str);
        }

        return substr($str, 0, $pos);
    }

    /**
     * Do internal beauty process.
     *
     * @param string $str  The text to beautify
     * @param int $flag  Beautify flag
     * @return string
     */
    protected static function beautifyStr($str, $flag)
    {
        // exclude from beauty if roman chars is detected
        if (($flag & static::IGNORE_ROMAN) === static::IGNORE_ROMAN && is_int(Roman::asInteger($str))) {
            return $str;
        }
        // exclude from beauty if found in exception list
        if (($flag & static::IGNORE_INLIST) === static::IGNORE_INLIST) {
            if (null !== ($ignore = self::getIgnored($str))) {
                return $ignore;
            }
        }

        $s = strtolower($str);
        for ($i = 0; $i < strlen($s); $i++) {
            if (!self::isDelimeter($s[$i])) {
                $s[$i] = strtoupper($s[$i]);
                break;
            }
        }

        return $s;
    }

    /**
     * Do the beauty.
     *
     * @param string $str
     * @return string
     */
    public static function beautify($str, $flag = self::IGNORE_NONE)
    {
        $result = null;

        $str = (string) $str;
        while (true) {
            if (0 === strlen(trim($str))) {
                break;
            }
            $bs = self::extract($str);
            $beauty = self::beautifyStr($bs, $flag);
            $pos = strpos($str, $bs) + strlen($bs) + 1;
            $matched = false;
            if ($pos >= strlen($str)) {
                $pos = strlen($str);
                $matched = true;
            }
            $tmp = substr($str, 0, $pos);
            if ($bs != $beauty) {
                $tmp = str_replace($bs, $beauty, $tmp);
            }
            $result .= $tmp;
            if (!$matched) {
                $str = substr($str, $pos);
            } else {
                break;
            }
        }

        return $result;
    }
}