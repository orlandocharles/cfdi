<?php

namespace Charles\Tests\CFDI\Node\Complemento\Pagos\Impuesto;

use Charles\CFDI\Common\Node;
use Charles\CFDI\Node\Complemento\Pagos\Impuesto\Traslado;
use PHPUnit\Framework\TestCase;

class TrasladoTest extends TestCase
{
    public function testConstructor()
    {
        $node = new Traslado();
        $this->assertInstanceOf(Node::class, $node);

        $this->assertEquals('pago10:Traslado', $node->getNodeName());
        $this->assertEquals('pago10:Traslados', $node->getParentNodeName());
        $this->assertEquals('pago10:Impuestos', $node->getWrapperNodeName());
    }
}
