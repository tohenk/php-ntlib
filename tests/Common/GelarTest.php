<?php

/*
 * The MIT License
 *
 * Copyright (c) 2014-2026 Toha <tohenk@yahoo.com>
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
use NTLAB\Lib\Common\Gelar;

class GelarTest extends TestCase
{
    public function testStrip()
    {
        $this->assertEquals('NAMANYA', Gelar::strip('NAMANYA'), 'Proper strip name without title');
        $this->assertEquals('NAMANYA', Gelar::strip('Drs. NAMANYA'), 'Proper strip name with title prefix');
        $this->assertEquals('NAMANYA', Gelar::strip('NAMANYA, M.Sc'), 'Proper strip name with title suffix');
        $this->assertEquals('NAMANYA', Gelar::strip('Drs. NAMANYA, M.Sc'), 'Proper strip name with title prefix and title suffix');
        $this->assertEquals('NAMANYA', Gelar::strip('Drs.  NAMANYA,  M.Sc'), 'Proper strip name with title prefix and title suffix with extra spaces');
    }

    public function testSplit()
    {
        $this->assertEquals(['NAMANYA', null, null], Gelar::split('NAMANYA'), 'Proper split name without title');
        $this->assertEquals(['NAMANYA', 'Drs.', null], Gelar::split('Drs. NAMANYA'), 'Proper split trip name with title prefix');
        $this->assertEquals(['NAMANYA', null, 'M.Sc'], Gelar::split('NAMANYA, M.Sc'), 'Proper split name with title suffix');
        $this->assertEquals(['NAMANYA', 'Drs.', 'M.Sc'], Gelar::split('Drs. NAMANYA, M.Sc'), 'Proper split name with title prefix and title suffix');
        $this->assertEquals(['NAMANYA', 'Drs.', 'M.Sc'], Gelar::split('Drs.  NAMANYA,  M.Sc'), 'Proper split name with title prefix and title suffix with extra spaces');
    }
}