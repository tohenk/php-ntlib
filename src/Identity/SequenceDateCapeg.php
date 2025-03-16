<?php

/*
 * The MIT License
 *
 * Copyright (c) 2025 Toha <tohenk@yahoo.com>
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

namespace NTLAB\Lib\Identity;

/**
 * A date and gender sequence decoder/encoder used as part of NIP.
 *
 * @author Toha <tohenk@yahoo.com>
 */
class SequenceDateCapeg extends SequenceDate
{
    public const TYPE_DIVISOR = 20;

    /**
     * {@inheritDoc}
     * @see \NTLAB\Lib\Identity\SequenceDate::extractDate()
     */
    protected function extractDate($str, $format, &$yr, &$mo, &$dy)
    {
        parent::extractDate($str, $format, $yr, $mo, $dy);
        // detect type and fix date
        if ($mo - self::TYPE_DIVISOR > 0) {
            $type = Employee::PPPK;
            $mo -= self::TYPE_DIVISOR;
        } else {
            $type = Employee::PNS;
        }
        $this->setValue($type, $this->keys[1]);
    }

    /**
     * {@inheritDoc}
     * @see \NTLAB\Lib\Identity\SequenceDate::doEncode()
     */
    protected function doEncode()
    {
        if ($date = $this->getValue()) {
            $dates = [];
            for ($i = 0; $i < strlen($this->format); $i ++) {
                $v = $date->format(substr($this->format, $i, 1));
                if ('m' === substr($this->format, $i, 1) && Employee::PPPK === $this->getValue($this->keys[1])) {
                    $v = (string) ((int) $v + self::TYPE_DIVISOR);
                }
                $dates[] = $v;
            }
            $this->raw = implode('', $dates);
        }
    }
}