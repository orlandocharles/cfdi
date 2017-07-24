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

use Charles\CFDI\Comprobante;
use Charles\CFDI\Node;
use DOMDocument;
use DOMElement;
use XSLTProcessor;

/**
 * This is the cfdi class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
class CFDI
{
    /**
     * @var string
     */
    const XSL_ENDPOINT = 'http://www.sat.gob.mx/sitio_internet/cfd/3/cadenaoriginal_3_3/cadenaoriginal_3_3.xslt';

    /**
     * @var string
     */
    protected $version = '3.3';

    protected $key;

    protected $cer;

    /**
     * @var \Charles\CFDI\Comprobante
     */
    protected $comprobante;

    /**
     * @param array     $data
     * @param $key
     * @param $cer
     */
    public function __construct($data, $cer, $key)
    {
        $this->comprobante = new Comprobante($data, $this->version);
        $this->cer = $cer;
        $this->key = $key;
    }

    /**
     * @param Charles\CFDI\Node     $node
     *
     * @return $this
     */
    public function add(Node $node)
    {
        $this->comprobante->add($node);
    }

    /**
     * @return string
     */
    protected function getCadenaOriginal()
    {
        $xsl = new DOMDocument();
        $xsl->load(static::XSL_ENDPOINT);

        $xslt = new XSLTProcessor();
        $xslt->importStyleSheet($xsl);

        $xml = new DOMDocument();
        $xml->loadXML($this->comprobante->getDocument()->saveXML());

        return $xslt->transformToXML($xml);
    }

    /**
     * @return string
     */
    protected function getSello()
    {
        $pkey = openssl_get_privatekey($this->key);
        openssl_sign($this->getCadenaOriginal(), $signature, $pkey, OPENSSL_ALGO_SHA256);
        openssl_free_key($pkey);
        return base64_encode($signature);
    }

    protected function putSello()
    {
        $this->comprobante->setAtributes(
            $this->comprobante->getElement(), [
                'Sello' => $this->getSello()
            ]
        );
    }

    /**
     * @param string    $path
     * @param string    $name
     */
    public function save($path, $name)
    {
        $this->comprobante->getDocument()->save($path.$name);
    }
}
