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

namespace NTLAB\Lib\Test\Identity;

use PHPUnit\Framework\TestCase;
use NTLAB\Lib\Identity\Ids\Nip;
use NTLAB\Lib\Identity\Validator\Nip as NipValidator;
use NTLAB\Lib\Identity\Provider\Provider;

class NipTest extends TestCase
{
    public function testNipPns()
    {
        $nip = new Nip('199909272020011004');
        $this->assertTrue($nip->isLenValid(), 'Length of NIP is 18');
        $date = new \DateTime();
        $date->setTimestamp(mktime(0, 0, 0, 9, 27, 1999));
        $this->assertEquals($date, $nip->getTglLahir(), 'Properly decode date of birth');
        $date->setTimestamp(mktime(0, 0, 0, 1, 1, 2020));
        $this->assertEquals($date, $nip->getTmtCapeg(), 'Properly decode TMT capeg');
        $this->assertEquals(1, $nip->getType(), 'Properly decode employee type');
        $this->assertEquals(1, $nip->getGender(), 'Properly decode gender');
        $this->assertEquals(4, $nip->getUrut(), 'Properly decode urut');
        $this->assertEquals('19990927 202001 1 004', $nip->formatRaw(' '), 'Properly format');
    }

    public function testNipPppk()
    {
        $nip = new Nip('200011122024322005');
        $this->assertTrue($nip->isLenValid(), 'Length of NIP is 18');
        $date = new \DateTime();
        $date->setTimestamp(mktime(0, 0, 0, 11, 12, 2000));
        $this->assertEquals($date, $nip->getTglLahir(), 'Properly decode date of birth');
        $date->setTimestamp(mktime(0, 0, 0, 12, 1, 2024));
        $this->assertEquals($date, $nip->getTmtCapeg(), 'Properly decode TMT capeg');
        $this->assertEquals(2, $nip->getType(), 'Properly decode employee type');
        $this->assertEquals(2, $nip->getGender(), 'Properly decode gender');
        $this->assertEquals(5, $nip->getUrut(), 'Properly decode urut');
        $this->assertEquals('20001112 202432 2 005', $nip->formatRaw(' '), 'Properly format');
    }

    public function testNipInvalid()
    {
        $nip = new Nip('19990927202001104');
        $this->assertFalse($nip->isLenValid(), 'Length of NIP must be 18');
        $nip = new Nip('1999092720200110004');
        $this->assertFalse($nip->isLenValid(), 'Length of NIP must be 18');
    }

    public function testValidator()
    {
        $provider = new NipMockProvider();
        $validator = new NipValidator($provider);
        $date = new \DateTime();
        $date->setTimestamp(mktime(0, 0, 0, 9, 27, 1999));
        $this->assertTrue($validator->validate([
            'id' => '199909272020011004',
            'dob' => $date,
            'type' => 1,
            'gender' => 1,
            'urut' => 4,
        ]), 'Properly validate NIP');
    }
}

class NipMockProvider extends Provider
{
    /**
     * {@inheritDoc}
     * @see \NTLAB\Lib\Identity\Provider\Provider::initialize()
     */
    public function initialize()
    {
        $this->name = 'NIP Mock Provider';
    }

    /**
     * {@inheritDoc}
     * @see \NTLAB\Lib\Identity\Provider\ProviderInterface::query()
     */
    public function query($id)
    {
        $nip = new Nip($id);
        if ($nip->isValid()) {
            return [
                'dob' => $nip->getTglLahir(),
                'capeg' => $nip->getTmtCapeg(),
                'type' => $nip->getType(),
                'gender' => $nip->getGender(),
                'urut' => $nip->getUrut(),
            ];
        }
    }

    /**
     * {@inheritDoc}
     * @see \NTLAB\Lib\Identity\Provider\ProviderInterface::getInfo()
     */
    public function getInfo($id)
    {
        $nip = new Nip($id);
        if ($nip->isValid()) {
            return [
                'dob' => $nip->getTglLahir(),
                'capeg' => $nip->getTmtCapeg(),
                'type' => $nip->getType(),
                'gender' => $nip->getGender(),
                'urut' => $nip->getUrut(),
            ];
        }
    }
}