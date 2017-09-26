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

use Charles\CFDI\Node\InformacionAduanera;
use PHPUnit\Framework\TestCase;

/**
 * This is the informacion aduanera test class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
class InformacionAduaneraTest extends TestCase
{
    /**
     *
     */
    protected $informacionAduanera;

    /**
     *
     */
    public function setUp()
    {
        $this->informacionAduanera = new InformacionAduanera();
    }

    /**
     *
     */
    public function testNodeName()
    {
        $this->assertEquals(
            $this->informacionAduanera->getNodeName(),
            'cfdi:InformacionAduanera'
        );
    }
}
