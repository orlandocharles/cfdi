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

use Charles\CFDI\Node\Parte;
use PHPUnit\Framework\TestCase;

/**
 * This is the parte test class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
class ParteTest extends TestCase
{
    /**
     *
     */
    protected $parte;

    /**
     *
     */
    public function setUp()
    {
        $this->parte = new Parte();
    }

    /**
     *
     */
    public function testNodeName()
    {
        $this->assertEquals(
            $this->parte->getNodeName(),
            'cfdi:Parte'
        );
    }
}
