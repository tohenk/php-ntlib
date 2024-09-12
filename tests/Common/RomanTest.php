<?php

/*
 * The MIT License
 *
 * Copyright (c) 2014-2024 Toha <tohenk@yahoo.com>
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

namespace NTLAB\Lib\Test;

use NTLAB\Lib\Common\Roman;

class RomanTest extends BaseTest
{
    public function testAsRoman()
    {
        $this->assertEquals(null, Roman::asRoman(0), 'Value below 0 should be converted as NULL');
        $this->assertEquals(null, Roman::asRoman(4000), 'Value above 4000 should be converted as NULL');
        $this->assertEquals(null, Roman::asRoman(99999), 'Value with digit number more than 4 should be converted as NULL');
        $this->assertEquals('MMMCMXCIX', Roman::asRoman(3999), '3999 => MMMCMXCIX');
        $this->assertEquals('MMCDXLIX', Roman::asRoman(2449), '2449 => MMCDXLIX');
    }

    public function testAsInteger()
    {
        $this->assertEquals(null, Roman::asInteger(''), 'Empty value should converted as NULL');
        $this->assertEquals(null, Roman::asInteger('TEST'), 'Invalid value should converted as NULL');
        $this->assertEquals(3999, Roman::asInteger('MMMCMXCIX'), 'MMMCMXCIX => 3999');
        $this->assertEquals(2449, Roman::asInteger('MMCDXLIX'), 'MMCDXLIX => 2449');
    }
}