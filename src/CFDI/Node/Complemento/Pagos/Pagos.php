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

use Charles\CFDI\Node\Complemento\Complemento;

/**
 * This is the timbre fiscal class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
class Pagos extends Complemento
{
    /**
     * @var string
     */
    protected $version = '1.0';
    /**
     * Node name.
     *
     * @var string
     */
    protected $nodeName = 'pago10:Pagos';

    /**
     * Pagos constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data, $this->attributes());
    }

    /**
     * Node attributes.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'xmlns:pago10' => 'http://www.sat.gob.mx/Pagos',
            'Version' => $this->version,
        ];
    }
}
