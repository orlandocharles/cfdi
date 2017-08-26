<?php

/*
 * This file is part of the CFDI project.
 *
 * (c) Orlando Charles <me@orlandocharles.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Charles\CFDI\Node;

use Charles\CFDI\Common\Node;

/**
 * This is the comprobante class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
class Comprobante extends Node
{
    /**
     * CFDI version.
     *
     * @var string
     */
    protected $version;

    /**
     * Node name.
     *
     * @var string
     */
    protected $nodeName = 'cfdi:Comprobante';

    /**
     * Create a new comprobante instance.
     *
     * @param array   $data
     * @param string  $version
     */
    public function __construct($data, $version)
    {
        $this->version = $version;
        $data = array_merge($this->attributes(), $data);

        parent::__construct($data);
    }

    /**
     * Node attributes.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'xmlns:cfdi' => 'http://www.sat.gob.mx/cfd/3',
            'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation' => 'http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd',
            'Version' => $this->version,
        ];
    }
}
