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

use NTLAB\Lib\Identity\Ids\Nrp;

class NrpTest extends BaseTest
{
    public function testNrp()
    {
        $nrp = new Nrp('95110029');
        $date = new \DateTime();
        $date->setTimestamp(mktime(0, 0, 0, 11, 1, 1995));
        $this->assertEquals($date, $nrp->getLahir(), 'Properly decode date of birth');
        $this->assertEquals(29, $nrp->getUrut(), 'Properly decode urut');
        $this->assertEquals('9511 0029', $nrp->formatRaw(' '), 'Properly format');
    }

    public function testNrpInvalid()
    {
        $nrp = new Nrp('9511029');
        $this->assertFalse($nrp->isLenValid(), 'Length of NRP must be 8');
        $nrp = new Nrp('951100029');
        $this->assertFalse($nrp->isLenValid(), 'Length of NRP must be 8');
    }
}