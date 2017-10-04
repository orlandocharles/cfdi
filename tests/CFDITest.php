<?php

namespace Charles\Tests\CFDI;

use CfdiUtils\Certificado;
use Charles\CFDI\CFDI;
use Charles\CFDI\Node\Emisor;
use Charles\CFDI\XmlResolver;
use PHPUnit\Framework\TestCase;

class CFDITest extends TestCase
{
    public function testConstructWithMinimalParameters()
    {
        $expectedFile = __DIR__ . '/assets/with-minimal-information.xml';

        $cfdi = new CFDI([], '', '');

        $this->assertFalse($cfdi->getResolver()->hasLocalPath());
        $this->assertXmlStringEqualsXmlFile($expectedFile, $cfdi->getXML());
        $this->assertXmlStringEqualsXmlFile($expectedFile, (string) $cfdi);
    }

    public function testConstructWithRandomAttributes()
    {
        $expectedFile = __DIR__ . '/assets/with-random-attributes.xml';

        $cfdi = new CFDI([
            'NoCertificado' => '12345678901234567890',
            'Foo' => 'Bar'
        ], '', '');

        $this->assertXmlStringEqualsXmlFile($expectedFile, $cfdi->getXML());
    }

    public function testAddMethodUsingEmisor()
    {
        $expectedFile = __DIR__ . '/assets/with-only-emisor.xml';

        $emisor = new Emisor([
            'Rfc' => 'AAA010101AAA',
            'Nombre' => 'ACCEM SERVICIOS EMPRESARIALES SC',
            'RegimenFiscal' => '601',
        ]);
        $cfdi = new CFDI([], '', '');
        $cfdi->add($emisor);

        $this->assertXmlStringEqualsXmlFile($expectedFile, $cfdi->getXML());
    }

    public function testSaveMethodCreatesAFileAndIsEqualToGetXml()
    {
        $cfdi = new CFDI([], '', '');
        $tempfile = tempnam('', '');
        $cfdi->save($tempfile, '');

        $this->assertFileExists($tempfile);
        $this->assertXmlStringEqualsXmlFile($tempfile, $cfdi->getXML());
        unlink($tempfile);
    }

    public function testAddCertificado()
    {
        $cerfile = __DIR__ . '/assets/certs/CSD01_AAA010101AAA.cer';
        $expectedFile = __DIR__ . '/assets/with-certificado.xml';

        $certificado = new Certificado($cerfile);
        $cfdi = new CFDI([], '', '');
        $cfdi->addCertificado($certificado);

        $this->assertXmlStringEqualsXmlFile($expectedFile, $cfdi->getXML());
    }

    public function testGetCadenaOrigenWithXmlResolverUsingLocalPath()
    {
        $resolver = new XmlResolver();

        $cfdi = new CFDI([], '', '');
        $cfdi->setResolver($resolver);

        $testTimeElapsed = is_dir($resolver->getLocalPath());

        $before = time();
        $this->assertNotEmpty($cfdi->getCadenaOriginal());
        $after = time();

        if ($testTimeElapsed) {
            $maximumMicrotime = 2;
            $this->assertLessThanOrEqual(
                $maximumMicrotime,
                $after - $before,
                "The method getCadenaOriginal take more than $maximumMicrotime microseconds"
            );
        }
    }

    public function testGetXmlResolverUsingLocalPath()
    {
        $expectedFile = __DIR__ . '/assets/with-sello.xml';

        $cerFile = __DIR__ . '/assets/certs/CSD01_AAA010101AAA.cer';
        $key = file_get_contents(__DIR__ . '/assets/certs/CSD01_AAA010101AAA.key.pem');
        $cfdi = new CFDI([], '', $key, new XmlResolver());
        $cfdi->addCertificado(new Certificado($cerFile));

        $this->assertXmlStringEqualsXmlFile($expectedFile, $cfdi->getXML());
    }
}
