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
    const IGNORE_EXCEPTION = 2;

    protected static $exceptions = array();
    protected static $delimeters = ' /-()';

    /**
     * Add beautify exception.
     *
     * @param array $array  The exception text
     */
    public static function addException($array = array())
    {
        if (null === $array || false === $array) {
            return;
        }
        if (!is_array($array)) {
            $array = array($array);
        }
        foreach ($array as $a) {
            $a = trim($a);
            if (!in_array($a, static::$exceptions)) {
                static::$exceptions[] = $a;
            }
        }
    }

    /**
     * Load beutify exception.
     *
     * @param string $filename  Exception filename
     * @return boolean true if loaded
     */
    public static function loadException($filename)
    {
        if (is_readable($filename)) {
            self::addException(file($filename));

            return true;
        }

        return false;
    }

    /**
     * Check if input is a beauty delimeter.
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
     * Is text found in exception.
     *
     * @param string $str  The text
     * @return boolean
     */
    protected static function isInException($str)
    {
        foreach (static::$exceptions as $except) {
            if (strtolower($str) == strtolower($except)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Extract string based on delimeter to beautified.
     *
     * @param string $str
     * @return string
     */
    protected static function extractStr($str)
    {
        $i = 0;
        $pos = null;
        while (true) {
            $is_delim = static::isDelimeter($str[$i]);
            if ($is_delim) {
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
        if (($flag & static::IGNORE_ROMAN) === 0 && is_int(Roman::asInteger($str))) {
            return $str;
        }
        // exclude from beauty if found in exception list
        if (($flag & static::IGNORE_EXCEPTION) === 0 && static::isInException($str)) {
            return $str;
        }

        $s = strtolower($str);
        for ($i = 0; $i < strlen($s); $i++) {
            $is_delim = static::isDelimeter($s[$i]);
            if (! $is_delim) {
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
            $bs = static::extractStr($str);
            $beauty = static::beautifyStr($bs, $flag);
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
            if (! $matched) {
                $str = substr($str, $pos);
            } else {
                break;
            }
        }

        return $result;
    }
}