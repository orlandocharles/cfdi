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
namespace PhpCfdi\CFDITests\Node\Complemento\Pagos;

use PhpCfdi\CFDI\Common\Node;
use PhpCfdi\CFDI\Node\Complemento\Pagos\Pago;
use PHPUnit\Framework\TestCase;

class PagoTest extends TestCase
{
    public function testConstructor()
    {
        $pago = new Pago();
        $this->assertInstanceOf(Node::class, $pago);
        $this->assertEquals('pago10:Pago', $pago->getNodeName());
        $this->assertEquals('pago10:Pagos', $pago->getParentNodeName());
        $this->assertEquals('cfdi:Complemento', $pago->getWrapperNodeName());

        $this->assertCount(0, $pago->getAttr('node'));
        $parentAttributes = $pago->getAttr('parent');
        $this->assertArrayHasKey('xmlns:pago10', $parentAttributes);
        $this->assertArrayHasKey('Version', $parentAttributes);
        $this->assertCount(0, $pago->getAttr('wrapper'));
    }

    public function testConstructorWithAttributes()
    {
        $expectedNodeAttributes = [
            'FechaPago' => '2017-01-01T12:00:00',
            'FormaDePagoP' => '01',
            'MonedaP' => 'USD',
            'TipoCambioP' => '21.00',
        ];
        $pago = new Pago($expectedNodeAttributes);

        $nodeAttributes = $pago->getAttr('node');
        $this->assertEquals($expectedNodeAttributes, $nodeAttributes);
    }
}
