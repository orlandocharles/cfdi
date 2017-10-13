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

use PhpCfdi\CFDI\CFDI;
use PhpCfdi\CFDI\XmlResolver;
use PHPUnit\Framework\TestCase;
use XmlResourceRetriever\Downloader\DownloaderInterface;

class XmlResolverTest extends TestCase
{
    public function testConstructor()
    {
        $resolver = new XmlResolver();
        $this->assertEquals($resolver->defaultLocalPath(), $resolver->getLocalPath());
        $this->assertTrue($resolver->hasLocalPath());
        $this->assertInstanceOf(DownloaderInterface::class, $resolver->getDownloader());
    }

    public function testSetLocalPath()
    {
        $default = XmlResolver::defaultLocalPath();
        $customPath = '/temporary/resources/';

        // constructed
        $resolver = new XmlResolver();
        $this->assertEquals($default, $resolver->getLocalPath());
        $this->assertTrue($resolver->hasLocalPath());

        // change to empty '' (disable)
        $resolver->setLocalPath('');
        $this->assertEquals('', $resolver->getLocalPath());
        $this->assertFalse($resolver->hasLocalPath());

        // change to custom value
        $resolver->setLocalPath($customPath);
        $this->assertEquals($customPath, $resolver->getLocalPath());
        $this->assertTrue($resolver->hasLocalPath());

        // change to default value
        $resolver->setLocalPath(null);
        $this->assertEquals($default, $resolver->getLocalPath());
        $this->assertTrue($resolver->hasLocalPath());
    }

    public function testRetrieveWithoutLocalPath()
    {
        $resolver = new XmlResolver('');
        $this->assertFalse($resolver->hasLocalPath());

        $resource = 'http://example.com/schemas/example.xslt';

        $this->assertEquals($resource, $resolver->resolve($resource));
    }

    /*
     * This test will download the CFDI::XSL_ENDPOINT and all its relatives
     * and put it in the default path of XmlResolver (project root)
     */
    public function testRetrieveWithDefaultLocalPath()
    {
        $resolver = new XmlResolver();
        $this->assertTrue($resolver->hasLocalPath());

        $localResource = $resolver->resolve(CFDI::XSL_ENDPOINT);

        $this->assertNotEmpty($localResource);
        $this->assertFileExists($localResource);
    }

    public function testResolveThrowsExceptionWhenUnknownResourceIsSet()
    {
        $resolver = new XmlResolver();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Unable to handle the resource');

        $resolver->resolve('http://example.org/example.xml');
    }

    public function providerObtainTypeFromUrl()
    {
        return [
            'xsd' => ['http://example.com/resource.xsd', XmlResolver::TYPE_XSD],
            'xlst' => ['http://example.com/resource.xslt', XmlResolver::TYPE_XSLT],
            'unknown' => ['http://example.com/resource.xml', ''],
            'empty' => ['', ''],
            'end with xml but no extension' => ['http://example.com/xml', ''],
        ];
    }

    /**
     * @dataProvider providerObtainTypeFromUrl
     * @param string $url
     * @param string $expectedType
     */
    public function testObtainTypeFromUrl($url, $expectedType)
    {
        $resolver = new XmlResolver();
        $this->assertEquals($expectedType, $resolver->obtainTypeFromUrl($url));
    }
}
