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
use NTLAB\Lib\Common\Beautifier;

class BeutifierTest extends TestCase
{
    public function testBeautify()
    {
        $this->assertEquals('Beautify Me', Beautifier::beautify('BEAUTIFY me'), 'BEAUTIFY me => Beautify Me');
        $this->assertEquals('Year MMIV', Beautifier::beautify('YEAR MMIV', Beautifier::IGNORE_ROMAN), 'Beautify should preserve roman');
        Beautifier::addIgnore(array('ME', 'YOU'));
        $this->assertEquals('Beautify ME And YOU', Beautifier::beautify('BEAUTIFY me and YOU', Beautifier::IGNORE_INLIST), 'Beautify should ignore if text is in exception');
        $this->assertEquals('Beautify ME And YOU Xx', Beautifier::beautify('BEAUTIFY Me and You Xx', Beautifier::IGNORE_INLIST | Beautifier::IGNORE_ROMAN), 'Beautify should ignore if flag specified');
    }
}