<?php
/*
 * This file is part of the eclipxe/cfdi library.
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

use PhpCfdi\CFDI\Node\Receptor;
use PHPUnit\Framework\TestCase;

/**
 * This is the receptor test class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
class ReceptorTest extends TestCase
{
    /**
     * @var Receptor
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
