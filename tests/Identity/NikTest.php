<?php

namespace NTLAB\Lib\Test;

use NTLAB\Lib\Identity\Ids\Nik;
use NTLAB\Lib\Identity\Validator\Nik as NikValidator;
use NTLAB\Lib\Identity\Provider\Provider;

class NikTest extends BaseTest
{
    public function testNik()
    {
        $nik = new Nik('3515155202000005');
        $date = new \DateTime();
        $date->setTimestamp(mktime(0, 0, 0, 2, 12, 2000));
        $this->assertEquals('351515', $nik->getWilayah(), 'Properly decode wilayah');
        $this->assertEquals($date, $nik->getTglLahir(), 'Properly decode date of birth');
        $this->assertEquals('P', $nik->getGender(), 'Properly decode gender');
        $this->assertEquals(5, $nik->getUrut(), 'Properly decode urut');
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