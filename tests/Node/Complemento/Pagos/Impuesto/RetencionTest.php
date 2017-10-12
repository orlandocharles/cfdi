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

namespace Charles\Tests\CFDI\Node\Complemento\Pagos\Impuesto;

use Charles\CFDI\Common\Node;
use Charles\CFDI\Node\Complemento\Pagos\Impuesto\Retencion;
use PHPUnit\Framework\TestCase;

class RetencionTest extends TestCase
{
    public function testConstructor()
    {
        $node = new Retencion();
        $this->assertInstanceOf(Node::class, $node);

        $this->assertEquals('pago10:Retencion', $node->getNodeName());
        $this->assertEquals('pago10:Retenciones', $node->getParentNodeName());
        $this->assertEquals('pago10:Impuestos', $node->getWrapperNodeName());
    }
}
