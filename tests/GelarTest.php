<?php

namespace NTLAB\Common\Test;

use NTLAB\Common\Gelar;

class GelarTest extends BaseTest
{
    public function testGelar()
    {
        $this->assertEquals('NAMANYA', Gelar::strip('Drs. NAMANYA'), 'Proper strip gelar depan');
        $this->assertEquals('NAMANYA', Gelar::strip('NAMANYA, M.Sc'), 'Proper strip gelar belakang');
        $this->assertEquals('NAMANYA', Gelar::strip('Drs. NAMANYA, M.Sc'), 'Proper strip gelar depan and gelar belakang');
        $this->assertEquals('NAMANYA', Gelar::strip('Drs.  NAMANYA,  M.Sc'), 'Proper strip gelar depan and gelar belakang with extra spaces');
    }
}