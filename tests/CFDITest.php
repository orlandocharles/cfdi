<?php

namespace Charles\Tests\CFDI;

use Charles\CFDI\CFDI;
use PHPUnit\Framework\TestCase;

class CFDITest extends TestCase
{
    public function testConstructWithMinimalParameters()
    {
        $expectedFile = __DIR__ . '/assets/with-minimal-information.xml';

        $cfdi = new CFDI([], '', '');
        $tempfile = tempnam('', '');
        $cfdi->save($tempfile, '');

        $this->assertFileExists($tempfile);
        $this->assertXmlFileEqualsXmlFile($expectedFile, $tempfile);
        unlink($tempfile);
    }

    public function testConstructWithRandomAttributes()
    {
        $expectedFile = __DIR__ . '/assets/with-random-attributes.xml';

        $cfdi = new CFDI([
            'NoCertificado' => '12345678901234567890',
            'Foo' => 'Bar'
        ], '', '');
        $tempfile = tempnam('', '');
        $cfdi->save($tempfile, '');

        $this->assertFileExists($tempfile);
        $this->assertXmlFileEqualsXmlFile($expectedFile, $tempfile);
        unlink($tempfile);
    }
}
