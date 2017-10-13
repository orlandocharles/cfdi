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
namespace PhpCfdi\CFDI\Node\Impuesto;

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
