<?php

/*
 * This file is part of the CFDI project.
 *
 * (c) Orlando Charles <me@orlandocharles.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Charles\CFDI\Node\Complemento\Pagos\Impuesto;

use Charles\CFDI\Common\Node;

/**
 * This is the impuesto class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
abstract class Impuesto extends Node
{
    /**
     * Wrapper node name.
     *
     * @var string
     */
    protected $wrapperNodeName = 'pago10:Impuestos';
}
