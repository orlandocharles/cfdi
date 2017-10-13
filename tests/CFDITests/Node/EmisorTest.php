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

use PhpCfdi\CFDI\Node\Emisor;
use PHPUnit\Framework\TestCase;

/**
 * This is the emisor test class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
class EmisorTest extends TestCase
{
    /**
     * @var Emisor
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
