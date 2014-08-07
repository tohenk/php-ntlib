<?php

namespace NTLAB\Common\Test;

use NTLAB\Common\Beautifier;

class BeutifierTest extends BaseTest
{
    public function testBeautify()
    {
        $this->assertEquals('Beautify Me', Beautifier::beautify('BEAUTIFY me'), 'BEAUTIFY me => Beautify Me');
        $this->assertEquals('Year MMIV', Beautifier::beautify('YEAR MMIV'), 'Beautify should preserve roman');
        Beautifier::addException(array('ME', 'YOU'));
        $this->assertEquals('Beautify me And YOU', Beautifier::beautify('BEAUTIFY me and YOU'), 'Beautify should ignore if text is in exception');
        $this->assertEquals('Beautify Me And You Xx', Beautifier::beautify('BEAUTIFY me and YOU xx', Beautifier::IGNORE_EXCEPTION | Beautifier::IGNORE_ROMAN), 'Beautify should ignore if flag specified');
    }
}