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

use Charles\CFDI\Node\Emisor;
use PHPUnit\Framework\TestCase;

/**
 * This is the emisor test class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
class EmisorTest extends TestCase
{
    /**
     *
     */
    protected $emisor;

    /**
     *
     */
    public function setUp()
    {
        $this->emisor = new Emisor();
    }

    /**
     *
     */
    public function testNodeName()
    {
        $this->assertEquals(
            $this->emisor->getNodeName(),
            'cfdi:Emisor'
        );
    }
}
