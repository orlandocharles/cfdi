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

use Charles\CFDI\Node\Receptor;
use PHPUnit\Framework\TestCase;

/**
 * This is the receptor test class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
class ReceptorTest extends TestCase
{
    /**
     *
     */
    protected $receptor;

    /**
     *
     */
    public function setUp()
    {
        $this->receptor = new Receptor();
    }

    /**
     *
     */
    public function testNodeName()
    {
        $this->assertEquals(
            $this->receptor->getNodeName(),
            'cfdi:Receptor'
        );
    }
}
