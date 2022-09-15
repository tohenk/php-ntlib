<?php

/*
 * The MIT License
 *
 * Copyright (c) 2022 Toha <tohenk@yahoo.com>
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
 * NRP (Nomor Register Pokok) decode/encode utility.
 *
 * @author Toha
 */
class Nrp extends Identity
{
    const NRP_LAHIR = 'lahir';
    const NRP_SEQUENCE = 'seq';

    /**
     * Constructor.
     *
     * @param string $nrp  NRP
     */
    public function __construct($nrp = null)
    {
        $this
            ->addSeq(new SequenceDate(4, self::NRP_LAHIR, 'ym'))
            ->addSeq(new SequenceSerial(4, self::NRP_SEQUENCE))
            ->decode($nrp);
    }

    /**
     * Get date of birth (only year and month of DOB).
     *
     * @return \DateTime
     */
    public function getLahir()
    {
        return $this->getValue(self::NRP_LAHIR);
    }

    /**
     * Get sequence.
     *
     * @return int
     */
    public function getUrut()
    {
        return $this->getValue(self::NRP_SEQUENCE);
    }
}