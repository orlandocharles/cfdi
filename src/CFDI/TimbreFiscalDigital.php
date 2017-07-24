<?php

/*
 * This file is part of the CFDI project.
 *
 * (c) Orlando Charles <me@orlandocharles.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Charles\CFDI;

/**
 * This is the timbre fiscal class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
class TimbreFiscal extends Node
{
    /**
     * Parent node name.
     *
     * @var string
     */
    protected $parentNodeName = 'cfdi:Complemento';

    /**
     * Node name.
     *
     * @var string
     */
    protected $nodeName = 'tfd:TimbreFiscalDigital';
}
