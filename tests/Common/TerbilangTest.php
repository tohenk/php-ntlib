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

namespace NTLAB\Lib\Test\Common;

use PHPUnit\Framework\TestCase;
use NTLAB\Lib\Common\Terbilang;

class TerbilangTest extends TestCase
{
    public function testDigit()
    {
        $terbilang = Terbilang::getInstance();
        $this->assertEquals('NOL', $terbilang->convert(0), '0 => NOL');
        $this->assertEquals('SATU', $terbilang->convert(1), '1 => SATU');
        $this->assertEquals('DUA', $terbilang->convert(2), '2 => DUA');
        $this->assertEquals('TIGA', $terbilang->convert(3), '3 => TIGA');
        $this->assertEquals('EMPAT', $terbilang->convert(4), '4 => EMPAT');
        $this->assertEquals('LIMA', $terbilang->convert(5), '5 => LIMA');
        $this->assertEquals('ENAM', $terbilang->convert(6), '6 => ENAM');
        $this->assertEquals('TUJUH', $terbilang->convert(7), '7 => TUJUH');
        $this->assertEquals('DELAPAN', $terbilang->convert(8), '8 => DELAPAN');
        $this->assertEquals('SEMBILAN', $terbilang->convert(9), '9 => SEMBILAN');
    }

    public function testSpecial()
    {
        $terbilang = Terbilang::getInstance();
        $this->assertEquals('SEPULUH', $terbilang->convert(10), '10 => SEPULUH');
        $this->assertEquals('SEBELAS', $terbilang->convert(11), '11 => SEBELAS');
        $this->assertEquals('EMPAT BELAS', $terbilang->convert(14), '14 => EMPAT BELAS');
        $this->assertEquals('SEMBILAN RATUS', $terbilang->convert(900), '900 => SEMBILAN RATUS');
        $this->assertEquals('SERIBU', $terbilang->convert(1000), '1000 => SERIBU');
        $this->assertEquals('SATU JUTA SEMBILAN RATUS SEMBILAN PULUH SEMBILAN RIBU LIMA RATUS SEMBILAN', $terbilang->convert(1999509), '1999509 => SATU JUTA SEMBILAN RATUS SEMBILAN PULUH SEMBILAN RIBU LIMA RATUS SEMBILAN');
    }

    public function testDecimal()
    {
        $terbilang = Terbilang::getInstance();
        $terbilang->setCustomDecimal(' | ');
        $this->assertEquals('SEMBILAN PULUH SEMBILAN KOMA SEMBILAN', $terbilang->convert(99.9), '99.9 => SEMBILAN PULUH SEMBILAN KOMA SEMBILAN');
        $this->assertEquals('SEMBILAN PULUH SEMBILAN, SEMBILAN', $terbilang->convert(99.9, true, Terbilang::DECIMAL_SYMBOL), '99.9 => SEMBILAN PULUH SEMBILAN, SEMBILAN');
        $this->assertEquals('SEMBILAN PULUH SEMBILAN SEMBILAN PER SEPULUH', $terbilang->convert(99.9, true, Terbilang::DECIMAL_PER), '99.9 => SEMBILAN PULUH SEMBILAN SEMBILAN PER SEPULUH');
        $this->assertEquals('SEMBILAN PULUH SEMBILAN | SEMBILAN', $terbilang->convert(99.9, true, Terbilang::DECIMAL_CUSTOM), '99.9 => SEMBILAN PULUH SEMBILAN | SEMBILAN');
    }
}