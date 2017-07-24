<?php

/*
 * This file is part of the CFDI project.
 *
 * (c) Orlando Charles <me@orlandocharles.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Charles\CFDI\Impuesto;

use Charles\CFDI\Node;

/**
 * This is the impuesto class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
class Impuesto extends Node
{
    /**
     * @var string
     */
    protected $wrapperNodeName = 'cfdi:Impuestos';
}
