<?php

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
