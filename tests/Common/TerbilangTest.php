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
        $this->assertEquals('NOL', Terbilang::from(0), '0 => NOL');
        $this->assertEquals('SATU', Terbilang::from(1), '1 => SATU');
        $this->assertEquals('DUA', Terbilang::from(2), '2 => DUA');
        $this->assertEquals('TIGA', Terbilang::from(3), '3 => TIGA');
        $this->assertEquals('EMPAT', Terbilang::from(4), '4 => EMPAT');
        $this->assertEquals('LIMA', Terbilang::from(5), '5 => LIMA');
        $this->assertEquals('ENAM', Terbilang::from(6), '6 => ENAM');
        $this->assertEquals('TUJUH', Terbilang::from(7), '7 => TUJUH');
        $this->assertEquals('DELAPAN', Terbilang::from(8), '8 => DELAPAN');
        $this->assertEquals('SEMBILAN', Terbilang::from(9), '9 => SEMBILAN');
    }

    public function testSpecial()
    {
        $this->assertEquals('SEPULUH', Terbilang::from(10), '10 => SEPULUH');
        $this->assertEquals('SEBELAS', Terbilang::from(11), '11 => SEBELAS');
        $this->assertEquals('EMPAT BELAS', Terbilang::from(14), '14 => EMPAT BELAS');
        $this->assertEquals('SEMBILAN RATUS', Terbilang::from(900), '900 => SEMBILAN RATUS');
        $this->assertEquals('SERIBU', Terbilang::from(1000), '1000 => SERIBU');
        $this->assertEquals('SATU JUTA SEMBILAN RATUS SEMBILAN PULUH SEMBILAN RIBU LIMA RATUS SEMBILAN', Terbilang::from(1999509), '1999509 => SATU JUTA SEMBILAN RATUS SEMBILAN PULUH SEMBILAN RIBU LIMA RATUS SEMBILAN');
    }

    public function testDecimal()
    {
        Terbilang::getInstance()->setCustomDecimal(' | ');
        $this->assertEquals('SEMBILAN PULUH SEMBILAN KOMA SEMBILAN', Terbilang::from(99.9), '99.9 => SEMBILAN PULUH SEMBILAN KOMA SEMBILAN');
        $this->assertEquals('SEMBILAN PULUH SEMBILAN, SEMBILAN', Terbilang::from(99.9, true, Terbilang::DECIMAL_SYMBOL), '99.9 => SEMBILAN PULUH SEMBILAN, SEMBILAN');
        $this->assertEquals('SEMBILAN PULUH SEMBILAN SEMBILAN PER SEPULUH', Terbilang::from(99.9, true, Terbilang::DECIMAL_PER), '99.9 => SEMBILAN PULUH SEMBILAN SEMBILAN PER SEPULUH');
        $this->assertEquals('SEMBILAN PULUH SEMBILAN | SEMBILAN', Terbilang::from(99.9, true, Terbilang::DECIMAL_CUSTOM), '99.9 => SEMBILAN PULUH SEMBILAN | SEMBILAN');
    }
}