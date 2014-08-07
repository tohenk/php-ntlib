<?php

namespace NTLAB\Common\Test;

use NTLAB\Common\Terbilang;

class TerbilangTest extends BaseTest
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