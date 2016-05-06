<?php

namespace Fsv\TypographyBundle\Tests\Typographer;

use Fsv\TypographyBundle\Typographer\SmartypantsTypographer;

class SmartypantsTypographerTest extends \PHPUnit_Framework_TestCase
{
    public function testTypography()
    {
        $typographer = new SmartypantsTypographer(1);

        $this->assertEquals('text', $typographer->typography('text'));
    }
}
