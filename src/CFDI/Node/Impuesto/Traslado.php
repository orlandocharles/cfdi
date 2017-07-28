<?php

/*
 * This file is part of the CFDI project.
 *
 * (c) Orlando Charles <me@orlandocharles.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Charles\CFDI\Node\Impuesto;

/**
 * This is the traslado class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
class Traslado extends Impuesto
{
    /**
     * Parent node name.
     *
     * @var string
     */
    protected $parentNodeName = 'cfdi:Traslados';

    /**
     * Node name.
     *
     * @var string
     */
    protected $nodeName = 'cfdi:Traslado';
}
