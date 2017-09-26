<?php

/*
 * This file is part of the CFDI project.
 *
 * (c) Orlando Charles <me@orlandocharles.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Charles\Tests\CFDI;

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
     *
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
