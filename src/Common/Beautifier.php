<?php

/*
 * The MIT License
 *
 * Copyright (c) 2014-2025 Toha <tohenk@yahoo.com>
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
    public const IGNORE_NONE = 0;
    public const IGNORE_ROMAN = 1;
    public const IGNORE_INLIST = 2;

    protected $flags = self::IGNORE_NONE;
    protected $delimeters = ' /-()';
    protected $ignores = [];

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
     * @param int $flags  Ignores flag
     * @return string
     */
    public function beautifyWord($str, $flags = null)
    {
        if (null === $flags) {
            $flags = $this->flags;
        }
        // exclude from beauty if roman chars is detected
        if (($flags & static::IGNORE_ROMAN) === static::IGNORE_ROMAN && is_int(Roman::asInteger($str))) {
            return $str;
        }
        // exclude from beauty if found in exception list
        if (($flags & static::IGNORE_INLIST) === static::IGNORE_INLIST) {
            if (null !== ($ignored = $this->getIgnored($str))) {
                return $ignored;
            }
        }
        $s = strtolower($str);
        for ($i = 0; $i < strlen($s); $i++) {
            if (!$this->isDelimeter($s[$i])) {
                $s[$i] = strtoupper($s[$i]);
                break;
            }
        }

        return $s;
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
        $str = (string) $str;
        while (true) {
            if (0 === strlen(trim($str))) {
                break;
            }
            $word = $this->extract($str);
            $beautified = $this->beautifyWord($word, $flags);
            $pos = strpos($str, $word) + strlen($word) + 1;
            $matched = false;
            if ($pos >= strlen($str)) {
                $pos = strlen($str);
                $matched = true;
            }
            $tmp = substr($str, 0, $pos);
            if ($word != $beautified) {
                $tmp = str_replace($word, $beautified, $tmp);
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