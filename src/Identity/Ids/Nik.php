<?php

/*
 * The MIT License
 *
 * Copyright (c) 2021-2025 Toha <tohenk@yahoo.com>
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

namespace NTLAB\Lib\Identity\Ids;

use NTLAB\Lib\Identity\Identity;
use NTLAB\Lib\Identity\Sequence;
use NTLAB\Lib\Identity\SequenceDateNik;
use NTLAB\Lib\Identity\SequenceSerial;

/**
 * NIK decode/encode utility.
 *
 * @author Toha <tohenk@yahoo.com>
 */
class Nik extends Identity
{
    public const NIK_WILAYAH = 'wilayah';
    public const NIK_DOB = 'dob';
    public const NIK_GENDER = 'gender';
    public const NIK_SEQUENCE = 'seq';

    /**
     * Constructor.
     *
     * @param string $nik  NIK
     */
    public function __construct($nik = null)
    {
        $this
            ->addSeq(new Sequence(6, self::NIK_WILAYAH))
            ->addSeq(new SequenceDateNik(6, [self::NIK_DOB, self::NIK_GENDER], 'dmy'))
            ->addSeq(new SequenceSerial(4, self::NIK_SEQUENCE))
            ->decode($nik);
    }

    /**
     * Get wilayah.
     *
     * @return string
     */
    public function getWilayah()
    {
        return $this->getValue(self::NIK_WILAYAH);
    }

    /**
     * Get date of birth.
     *
     * @return \DateTime
     */
    public function getTglLahir()
    {
        return $this->getValue(self::NIK_DOB);
    }

    /**
     * Get gender.
     *
     * @return string
     */
    public function getGender()
    {
        return $this->getValue(self::NIK_GENDER);
    }

    /**
     * Get sequence.
     *
     * @return int
     */
    public function getUrut()
    {
        return $this->getValue(self::NIK_SEQUENCE);
    }
}
