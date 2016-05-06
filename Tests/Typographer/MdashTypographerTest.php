<?php

namespace Fsv\TypographyBundle\Tests\Typographer;

use Fsv\TypographyBundle\Typographer\MdashTypographer;

class MdashTypographerTest extends \PHPUnit_Framework_TestCase
{
    public function testTypography()
    {
        $typographer = new MdashTypographer(['Text.paragraphs' => 'off']);

        $this->assertEquals('текст', $typographer->typography('текст'));
    }
}
