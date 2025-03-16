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
use NTLAB\Lib\Identity\Ids\Nik;
use NTLAB\Lib\Identity\Validator\Nik as NikValidator;
use NTLAB\Lib\Identity\Provider\Provider;

class NikTest extends TestCase
{
    public function testNik()
    {
        $nik = new Nik('3515155202000005');
        $date = new \DateTime();
        $date->setTimestamp(mktime(0, 0, 0, 2, 12, 2000));
        $this->assertTrue($nik->isLenValid(), 'Length of NIK is 16');
        $this->assertEquals('351515', $nik->getWilayah(), 'Properly decode wilayah');
        $this->assertEquals($date, $nik->getTglLahir(), 'Properly decode date of birth');
        $this->assertEquals('P', $nik->getGender(), 'Properly decode gender');
        $this->assertEquals(5, $nik->getUrut(), 'Properly decode urut');
    }

    public function testNikInvalid()
    {
        $nik = new Nik('351515520200005');
        $this->assertFalse($nik->isLenValid(), 'Length of NIK must be 16');
        $nik = new Nik('35151552020000005');
        $this->assertFalse($nik->isLenValid(), 'Length of NIK must be 16');
    }

    public function testValidator()
    {
        $provider = new NikMockProvider();
        $validator = new NikValidator($provider);
        $date = new \DateTime();
        $date->setTimestamp(mktime(0, 0, 0, 2, 12, 2000));
        $this->assertTrue($validator->validate([
            'id' => '3515155202000005',
            'wilayah' => '351515',
            'dob' => $date,
            'gender' => 'P',
            'urut' => 5,
        ]), 'Properly validate NIK');
    }
}

class NikMockProvider extends Provider
{
    /**
     * {@inheritDoc}
     * @see \NTLAB\Lib\Identity\Provider\Provider::initialize()
     */
    public function initialize()
    {
        $this->name = 'NIK Mock Provider';
    }

    /**
     * {@inheritDoc}
     * @see \NTLAB\Lib\Identity\Provider\ProviderInterface::query()
     */
    public function query($id)
    {
        $nik = new Nik($id);
        if ($nik->isValid()) {
            return [
                'wilayah' => $nik->getWilayah(),
                'dob' => $nik->getTglLahir(),
                'gender' => $nik->getGender(),
                'urut' => $nik->getUrut(),
            ];
        }
    }

    /**
     * {@inheritDoc}
     * @see \NTLAB\Lib\Identity\Provider\ProviderInterface::getInfo()
     */
    public function getInfo($id)
    {
        $nik = new Nik($id);
        if ($nik->isValid()) {
            return [
                'wilayah' => $nik->getWilayah(),
                'dob' => $nik->getTglLahir(),
                'gender' => $nik->getGender(),
                'urut' => $nik->getUrut(),
            ];
        }
    }
}