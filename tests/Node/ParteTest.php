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

use PhpCfdi\CFDI\Node\Parte;
use PHPUnit\Framework\TestCase;

/**
 * This is the parte test class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
class ParteTest extends TestCase
{
    /**
     * @var Parte
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
