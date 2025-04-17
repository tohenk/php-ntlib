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
 * Roman number to text and vice versa.
 *
 * @author Toha <tohenk@yahoo.com>
 */
class Roman
{
    public const BASE1_COUNT = 3;
    public const BASE2_COUNT = 1;

    protected $values = [1, 5];
    protected $chars = 'IVXLCDM';

    /**
     * Get instance.
     *
     * @return \NTLAB\Lib\Common\Roman
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
     * Convert roman value into integer.
     *
     * @param string $s  Roman value
     * @return int
     */
    public static function asInteger($s)
    {
        return static::getInstance()
            ->toInteger($s);
    }

    /**
     * Convert integer to roman characters.
     *
     * @param int $value  Integer value
     * @return string Roman characters.
     */
    public static function asRoman($value)
    {
        return static::getInstance()
            ->toRoman($value);
    }

    /**
     * Get the index of roman char.
     *
     * @param string $char
     * @return int index of char, starting from 0, false if no match
     */
    protected function getCharIndex($char)
    {
        return strpos($this->chars, $char);
    }

    /**
     * Check if input is a valid roman characters.
     *
     * @param string $chars
     * @return bool
     */
    protected function isValid($chars)
    {
        $matchCount = 1;
        $lastIndex = null;
        $lastMatch = null;
        $lastChar = null;
        $checkOrder = false;
        for ($i = 0; $i < strlen($chars); $i++) {
            $char = $chars[$i];
            $saveIndex = true;
            if ($char != $lastChar) {
                $matchCount = 1;
                $lastChar = $char;
            } else {
                $matchCount++;
            }
            $index = $this->getCharIndex($char);
            if ($index === false) {
                return false;
            } else {
                // First index char repetition max is 3
                if ($index % 2 == 0 && $matchCount > static::BASE1_COUNT) {
                    return false;
                }
                // Second index char repetition max is 1
                if ($index % 2 == 1 && $matchCount > static::BASE2_COUNT) {
                    return false;
                }
                // Check order, must be higher to lower, except itermediate between second and first
                if (is_integer($lastIndex)) {
                    if ($index > $lastIndex) {
                        if ($lastMatch > 1) {
                            return false;
                        }
                        if ($checkOrder) {
                            return false;
                        }
                        // Check allowed combination
                        if ($lastIndex % 2 == 1) {
                            return false;
                        }
                        if ($index > $lastIndex + 2) {
                            return false;
                        }
                        // Check wheter more char allowed
                        $digit = (int) ($lastIndex / 2);
                        if ($digit == 0 && $i < strlen($chars) - 1) {
                            return false;
                        }
                        // If more char, then check the next order, must be lower
                        if ($matchCount > 1) {
                            return false;
                        }
                        $saveIndex = false;
                        $checkOrder = true;
                    } elseif ($index == $lastIndex) {
                        if ($checkOrder) {
                            return false;
                        }
                    } else {
                        $checkOrder = false;
                    }
                }
                if ($saveIndex) {
                    $lastIndex = $index;
                }
            }
            if ($saveIndex) {
                $lastMatch = $matchCount;
            }
        }

        return true;
    }

    /**
     * Convert roman value to integer based on it's base value.
     *
     * @param string $char
     * @return int
     */
    protected function getValue($char)
    {
        $index = $this->getCharIndex($char);
        $base = $this->values[$index % 2];
        $digit = (int) ($index / 2);

        return (int) $base * ('1e+' . $digit);
    }

    /**
     * Get the maximum number digit allowed.
     *
     * @return int
     */
    protected function getMaxDigit()
    {
        return ceil(strlen($this->chars) / 2);
    }

    /**
     * Convert roman value into integer.
     *
     * @param string $s  Roman value
     * @return int
     */
    public function toInteger($s)
    {
        $s = strtoupper($s);
        if ($s == '' || $this->isValid($s) == false) {
            return;
        }

        $i = 0;
        $result = 0;
        $len = strlen($s);
        while (true) {
            $value = $this->getValue($s[$i]);
            if ($i + 1 < $len && $this->getCharIndex($s[$i]) < $this->getCharIndex($s[$i + 1])) {
                $i++;
                $value = $this->getValue($s[$i]) - $value;
            }
            $result += $value;
            $i++;
            if ($i == $len) {
                break;
            }
        }

        return (int) $result;
    }

    /**
     * Convert integer to roman characters.
     *
     * @param int $value  Integer value
     * @return string Roman characters.
     */
    public function toRoman($value)
    {
        $result = null;
        if ($value > 0) {
            $s = strval($value);
            $digit = strlen($s);
            if ($digit > $this->getMaxDigit()) {
                return;
            }
            for ($i = 0; $i < $digit; $i++) {
                $val = intval($s[$i]);
                $index = ($digit - $i - 1) * 2;
                switch ($val) {
                    case 0:
                        break;
                    case 1:
                    case 2:
                    case 3:
                        $result .= str_repeat($this->chars[$index], $val);
                        break;
                    case 4:
                        // value is too high, e.g. >= 4000
                        if ($index + 1 >= strlen($this->chars)) {
                            return;
                        }
                        $result .= substr($this->chars, $index, 2);
                        break;
                    case 5:
                    case 6:
                    case 7:
                    case 8:
                        $result .= $this->chars[$index + 1];
                        if ($val > 5) {
                            $result .= str_repeat($this->chars[$index], $val - 5);
                        }
                        break;
                    case 9:
                        $result .= $this->chars[$index] . $this->chars[$index + 2];
                        break;
                }
            }
        }

        return $result;
    }
}