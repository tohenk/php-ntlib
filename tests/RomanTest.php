<?php

namespace NTLAB\Common\Test;

use NTLAB\Common\Roman;

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