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
namespace Charles\Tests\CFDI\Node;

use Charles\CFDI\Node\Relacionado;
use PHPUnit\Framework\TestCase;

/**
 * This is the relacionado test class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
class RelaciondoTest extends TestCase
{
    /**
     * @var Relacionado
     */
    protected $relacionado;

    /**
     *
     */
    public function setUp()
    {
        $this->relacionado = new Relacionado();
    }

    /**
     *
     */
    public function testNodeName()
    {
        $this->assertEquals(
            $this->relacionado->getNodeName(),
            'cfdi:CfdiRelacionado'
        );
    }

    /**
     *
     */
    public function testParentNodeName()
    {
        $this->assertEquals(
            $this->relacionado->getParentNodeName(),
            'cfdi:CfdiRelacionados'
        );
    }
}
