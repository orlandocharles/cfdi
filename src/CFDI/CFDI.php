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

use Charles\CFDI\Node\Comprobante;
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
     * SAT XSL endpoint
     *
     * @var string
     */
    const XSL_ENDPOINT = 'http://www.sat.gob.mx/sitio_internet/cfd/3/cadenaoriginal_3_3/cadenaoriginal_3_3.xslt';

    /**
     * CFDI version.
     *
     * @var string
     */
    protected $version = '3.3';

    /**
     * CSD key.
     *
     * @var string
     */
    protected $key;

    /**
     * CSD cer
     *
     * @var string
     */
    protected $cer;

    /**
     * Comprobante instance.
     *
     * @var \Charles\CFDI\Comprobante
     */
    protected $comprobante;

    /**
     * Create a new cfdi instance.
     *
     * @param array     $data
     * @param string    $key
     * @param string    $cer
     */
    public function __construct($data, $cer, $key)
    {
        $this->comprobante = new Comprobante($data, $this->version);
        $this->cer = $cer;
        $this->key = $key;
    }

    /**
     * Add new node to comprobante instance.
     *
     * @param $node
     *
     * @return void
     */
    public function add($node)
    {
        $this->comprobante->add($node);
    }

    /**
     * Gets the original string.
     *
     * @return string
     */
    public function getCadenaOriginal()
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
     * Get sello
     *
     * @return string
     */
    protected function getSello()
    {
        $pkey = openssl_get_privatekey($this->key);
        openssl_sign(@$this->getCadenaOriginal(), $signature, $pkey, OPENSSL_ALGO_SHA256);
        openssl_free_key($pkey);
        return base64_encode($signature);
    }

    /**
     * Put the stamp on the voucher.
     *
     * @return void
     */
    protected function putSello()
    {
        $this->comprobante->setAtributes(
            $this->comprobante->getElement(), [
                'Sello' => $this->getSello()
            ]
        );
    }

    /**
     * Get Certificado.
     *
     * @return string
     */
    protected function getCertificado()
    {
        $cer = preg_replace('/(-+[^-]+-+)/', '', $this->cer);
        $cer = preg_replace('/\s+/', '', $cer);
        return $cer;
    }

    /**
     * Put the certificate on the voucher.
     *
     * @return void
     */
    protected function putCertificado()
    {
        $this->comprobante->setAtributes(
            $this->comprobante->getElement(), [
                'Certificado' => $this->getCertificado()
            ]
        );
    }

    /**
     * Returns the xml with the stamp and certificate attributes.
     *
     * @return DOMDocument
     */
    protected function xml()
    {
        $this->putSello();
        $this->putCertificado();
        return $this->comprobante->getDocument();
    }

    /**
     * Get the xml.
     *
     * @return string
     */
    public function getXML()
    {
        return $this->xml()->saveXML();
    }

    /**
     * Save the voucher.
     *
     * @param string    $path
     * @param string    $name
     *
     * @return void
     */
    public function save($path, $name)
    {
        $this->xml()->save($path.$name);
    }
}
