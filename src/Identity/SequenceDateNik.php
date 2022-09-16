<?php

/*
 * The MIT License
 *
 * Copyright (c) 2021-2022 Toha <tohenk@yahoo.com>
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
 * A date and gender sequence decoder/encoder used as part of NIK.
 *
 * @author Toha
 */
class SequenceDateNik extends SequenceDate
{
    const GENDER_MALE = 'L';
    const GENDER_FEMALE = 'P'; 
    const GENDER_DIVISOR = 40;

    /**
     * {@inheritDoc}
     * @see \NTLAB\Lib\Identity\SequenceDate::extractDate()
     */
    protected function extractDate($str, $format, &$yr, &$mo, &$dy)
    {
        parent::extractDate($str, $format, $yr, $mo, $dy);
        // detect gender and fix date
        if ($dy - self::GENDER_DIVISOR > 0) {
            $gender = self::GENDER_FEMALE;
            $dy -= self::GENDER_DIVISOR;
        } else {
            $gender = self::GENDER_MALE;
        }
        $this->setValue($gender, $this->keys[1]);
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
                if ('d' == substr($this->format, $i, 1) && self::GENDER_FEMALE == $this->getValue($this->keys[1])) {
                    $v = (string) ((int) $v + self::GENDER_DIVISOR);
                }
                $dates[] = $v;
            }
            $this->raw = implode('', $dates);
        }
    }
}