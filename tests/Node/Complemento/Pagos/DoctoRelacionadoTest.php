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
use PhpCfdi\CFDI\Node\Complemento\Pagos\DoctoRelacionado;
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
