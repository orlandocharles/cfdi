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
namespace PhpCfdi\Tests\CFDI\Node\Complemento\Pagos\Impuesto;

use PhpCfdi\CFDI\Common\Node;
use PhpCfdi\CFDI\Node\Complemento\Pagos\Impuesto\Traslado;
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
