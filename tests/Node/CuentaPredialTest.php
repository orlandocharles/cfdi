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

use Charles\CFDI\Node\CuentaPredial;
use PHPUnit\Framework\TestCase;

/**
 * This is the cuenta predial test class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
class CuentaPredialTest extends TestCase
{
    /**
     *
     */
    protected $cuentaPredial;

    /**
     *
     */
    public function setUp()
    {
        $this->cuentaPredial = new CuentaPredial();
    }

    /**
     *
     */
    public function testNodeName()
    {
        $this->assertEquals(
            $this->cuentaPredial->getNodeName(),
            'cfdi:CuentaPredial'
        );
    }
}
