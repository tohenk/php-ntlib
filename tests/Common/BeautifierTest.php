<?php

namespace NTLAB\Lib\Test;

use NTLAB\Lib\Common\Beautifier;

class BeutifierTest extends BaseTest
{
    public function testBeautify()
    {
        $this->assertEquals('Beautify Me', Beautifier::beautify('BEAUTIFY me'), 'BEAUTIFY me => Beautify Me');
        $this->assertEquals('Year MMIV', Beautifier::beautify('YEAR MMIV', Beautifier::IGNORE_ROMAN), 'Beautify should preserve roman');
        Beautifier::addIgnore(array('ME', 'YOU'));
        $this->assertEquals('Beautify ME And YOU', Beautifier::beautify('BEAUTIFY me and YOU', Beautifier::IGNORE_INLIST), 'Beautify should ignore if text is in exception');
        $this->assertEquals('Beautify ME And YOU Xx', Beautifier::beautify('BEAUTIFY Me and You Xx', Beautifier::IGNORE_INLIST | Beautifier::IGNORE_ROMAN), 'Beautify should ignore if flag specified');
    }
}