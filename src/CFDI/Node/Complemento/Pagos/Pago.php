<?php

/*
 * This file is part of the CFDI project.
 *
 * (c) Orlando Charles <me@orlandocharles.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Charles\CFDI\Node\Complemento\Pagos;

use Charles\CFDI\Common\Node;

/**
 * This is the timbre fiscal class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
class Pago extends Node
{
    /**
     * @var string
     */
    protected $wrapperNodeName = 'cfdi:Complemento';

    /**
     * @var string
     */
    protected $parentNodeName = 'pago10:Pagos';
    /**
     * Node name.
     *
     * @var string
     */
    protected $nodeName = 'pago10:Pago';

    /**
     * Pago constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data, $this->parentAttributes());
    }

    /**
     * Node attributes.
     *
     * @return array
     */
    public function parentAttributes()
    {
        return [
            'xmlns:pago10' => 'http://www.sat.gob.mx/Pagos',
            'Version' => '1.0',
        ];
    }
}
