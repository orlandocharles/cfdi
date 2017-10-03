<?php

namespace Charles\Tests\CFDI\Node\Complemento\Pagos;

use Charles\CFDI\Common\Node;
use Charles\CFDI\Node\Complemento\Pagos\DoctoRelacionado;
use PHPUnit\Framework\TestCase;

class DoctoRelacionadoTest extends TestCase
{
    public function testConstructor()
    {
        $node = new DoctoRelacionado();
        $this->assertInstanceOf(Node::class, $node);

        $this->assertEquals('pago10:DoctoRelacionado', $node->getNodeName());
        $this->assertEmpty($node->getParentNodeName());
        $this->assertEmpty($node->getWrapperNodeName());
    }
}
