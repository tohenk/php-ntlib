<?php

/*
 * The MIT License
 *
 * Copyright (c) 2021-2023 Toha <tohenk@yahoo.com>
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
use NTLAB\Lib\Identity\SequenceDate;
use NTLAB\Lib\Identity\SequenceSerial;

/**
 * NIP decode/encode utility.
 *
 * @author Toha
 */
class Nip extends Identity
{
    const NIP_DOB = 'dob';
    const NIP_CAPEG = 'capeg';
    const NIP_GENDER = 'gender';
    const NIP_SEQUENCE = 'seq';

    /**
     * Constructor.
     *
     * @param string $nip  NIP
     */
    public function __construct($nip = null)
    {
        $this
            ->addSeq(new SequenceDate(8, self::NIP_DOB))
            ->addSeq(new SequenceDate(6, self::NIP_CAPEG, 'Ym'))
            ->addSeq(new SequenceSerial(1, self::NIP_GENDER))
            ->addSeq(new SequenceSerial(3, self::NIP_SEQUENCE))
            ->decode($nip);
    }

    /**
     * Get date of birth.
     *
     * @return \DateTime
     */
    public function getTglLahir()
    {
        return $this->getValue(self::NIP_DOB);
    }

    /**
     * Get TMT CPNS.
     *
     * @return \DateTime
     */
    public function getTmtCapeg()
    {
        return $this->getValue(self::NIP_CAPEG);
    }

    /**
     * Get gender.
     *
     * @return int
     */
    public function getGender()
    {
        return $this->getValue(self::NIP_GENDER);
    }

    /**
     * Get sequence.
     *
     * @return int
     */
    public function getUrut()
    {
        return $this->getValue(self::NIP_SEQUENCE);
    }
}