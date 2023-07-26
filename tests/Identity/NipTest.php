<?php

namespace NTLAB\Lib\Test;

use NTLAB\Lib\Identity\Ids\Nip;
use NTLAB\Lib\Identity\Validator\Nip as NipValidator;
use NTLAB\Lib\Identity\Provider\Provider;

class NipTest extends BaseTest
{
    public function testNip()
    {
        $nip = new Nip('199909272020011004');
        $this->assertTrue($nip->isLenValid(), 'Length of NIP is 18');
        $date = new \DateTime();
        $date->setTimestamp(mktime(0, 0, 0, 9, 27, 1999));
        $this->assertEquals($date, $nip->getTglLahir(), 'Properly decode date of birth');
        $date->setTimestamp(mktime(0, 0, 0, 1, 1, 2020));
        $this->assertEquals($date, $nip->getTmtCapeg(), 'Properly decode TMT capeg');
        $this->assertEquals(1, $nip->getGender(), 'Properly decode gender');
        $this->assertEquals(4, $nip->getUrut(), 'Properly decode urut');
        $this->assertEquals('19990927 202001 1 004', $nip->formatRaw(' '), 'Properly format');
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
                'gender' => $nip->getGender(),
                'urut' => $nip->getUrut(),
            ];
        }
    }
}