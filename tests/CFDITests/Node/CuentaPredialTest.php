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
namespace PhpCfdi\CFDITests\Node;

use PhpCfdi\CFDI\Node\CuentaPredial;
use PHPUnit\Framework\TestCase;

/**
 * This is the cuenta predial test class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
class CuentaPredialTest extends TestCase
{
    /**
     * @var CuentaPredial
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
