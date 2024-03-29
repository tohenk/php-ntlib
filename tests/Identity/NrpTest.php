<?php

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