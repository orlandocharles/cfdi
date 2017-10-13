<?php

/*
 * This file is part of the eclipxe13/cfdi library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Carlos C Soto <eclipxe13@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @link https://github.com/eclipxe13/cfdi GitHub
 * @link https://github.com/orlandocharles/cfdi Original project
 */
namespace PhpCfdi\CFDITests;

use CfdiUtils\Certificado;
use PhpCfdi\CFDI\CFDI;
use PhpCfdi\CFDI\Node\Emisor;
use PhpCfdi\CFDI\XmlResolver;
use PHPUnit\Framework\TestCase;

class CFDITest extends TestCase
{
    public function testConstructWithMinimalParameters()
    {
        $expectedFile = Util::asset('with-minimal-information.xml');

        $cfdi = new CFDI([]);

        $this->assertFalse($cfdi->getResolver()->hasLocalPath());
        $this->assertXmlStringEqualsXmlFile($expectedFile, $cfdi->getXML());
        $this->assertXmlStringEqualsXmlFile($expectedFile, (string) $cfdi);
    }

    public function testConstructWithRandomAttributes()
    {
        $expectedFile = Util::asset('with-random-attributes.xml');

        $cfdi = new CFDI([
            'NoCertificado' => '12345678901234567890',
            'Foo' => 'Bar',
        ]);

        $this->assertXmlStringEqualsXmlFile($expectedFile, $cfdi->getXML());
    }

    public function testAddMethodUsingEmisor()
    {
        $expectedFile = Util::asset('with-only-emisor.xml');

        $emisor = new Emisor([
            'Rfc' => 'AAA010101AAA',
            'Nombre' => 'ACCEM SERVICIOS EMPRESARIALES SC',
            'RegimenFiscal' => '601',
        ]);
        $cfdi = new CFDI([]);
        $cfdi->add($emisor);

        $this->assertXmlStringEqualsXmlFile($expectedFile, $cfdi->getXML());
    }

    public function testSaveMethodCreatesAFileAndIsEqualToGetXml()
    {
        $cfdi = new CFDI([]);
        $tempfile = tempnam('', '');
        $cfdi->save($tempfile);

        $this->assertFileExists($tempfile);
        $this->assertXmlStringEqualsXmlFile($tempfile, $cfdi->getXML());
        unlink($tempfile);
    }

    public function testAddCertificado()
    {
        $cerfile = Util::asset('certs/CSD01_AAA010101AAA.cer');
        $expectedFile = Util::asset('with-certificado.xml');

        $certificado = new Certificado($cerfile);
        $cfdi = new CFDI([]);
        $cfdi->addCertificado($certificado);

        $this->assertXmlStringEqualsXmlFile($expectedFile, $cfdi->getXML());
    }

    public function testGetCadenaOrigenWithXmlResolverUsingLocalPath()
    {
        $resolver = new XmlResolver();

        $cfdi = new CFDI([]);
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
        $expectedFile = Util::asset('with-sello.xml');

        $cfdi = new CFDI(['NoCertificado' => '30001000000300023708'], new XmlResolver());

        $key = file_get_contents(Util::asset('certs/CSD01_AAA010101AAA.key.pem'));
        $cfdi->setPrivateKey($key);

        $this->assertXmlStringEqualsXmlFile($expectedFile, $cfdi->getXML());
    }

    public function testSetPrivateKeyWithInvalidData()
    {
        $cfdi = new CFDI([]);

        $this->expectException(\UnexpectedValueException::class);

        $cfdi->setPrivateKey('foo');
    }

    public function testSetPrivateKeyWithValidData()
    {
        $cfdi = new CFDI([]);
        $privateKey = file_get_contents(Util::asset('certs/CSD01_AAA010101AAA.key.pem'));
        $cfdi->setPrivateKey($privateKey);
        $this->assertStringStartsWith('-----BEGIN PRIVATE KEY-----', $cfdi->getPrivateKey());
        $cfdi->setPrivateKey('');
        $this->assertSame('', $cfdi->getPrivateKey());
    }
}
