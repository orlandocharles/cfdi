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

use CfdiUtils\CadenaOrigen;
use CfdiUtils\Certificado;
use Charles\CFDI\Common\Node;
use Charles\CFDI\Node\Comprobante;
use DOMDocument;

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
     * @var boolean
     */
    protected $xslt;

    /**
     * Comprobante instance.
     *
     * @var Comprobante
     */
    protected $comprobante;

    /**
     * Create a new cfdi instance.
     *
     * @param array     $data
     * @param string    $key
     * @param string    $cer
     * @param boolean   $xslt
     */
    public function __construct(array $data, string $cer, string $key, bool $xslt = false)
    {
        $this->comprobante = new Comprobante($data, $this->version);
        $this->cer = $cer;
        $this->key = $key;
        $this->xslt = $xslt;
    }

    /**
     * Add new node to comprobante instance.
     *
     * @param Node $node
     *
     * @return void
     */
    public function add(Node $node)
    {
        $this->comprobante->add($node);
    }

    /**
     * Change the initial certificate with the current certificate data and also
     * set the NoCertificado information
     *
     * @param Certificado $certificado
     */
    public function addCertificado(Certificado $certificado)
    {
        $this->cer = base64_encode(file_get_contents($certificado->getFilename()));
        $this->comprobante->setAtributes(
            $this->comprobante->getElement(),
            [
                'NoCertificado' => $certificado->getSerial()
            ]
        );
    }

    /**
     * Gets the original string.
     *
     * @return string
     */
    public function getCadenaOriginal(): string
    {
        $location = (! $this->xslt) ? static::XSL_ENDPOINT : __DIR__ . '/Utils/cadenaoriginal_3_3.xslt';
        $builder = new CadenaOrigen();
        return $builder->build(
            $this->comprobante->getDocument()->saveXML(),
            $location
        );
    }

    /**
     * Get sello
     *
     * @return string
     */
    protected function getSello(): string
    {
        if ('' === $this->key) {
            return '';
        }
        $pkey = openssl_get_privatekey($this->key);
        openssl_sign($this->getCadenaOriginal(), $signature, $pkey, OPENSSL_ALGO_SHA256);
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
            $this->comprobante->getElement(),
            [
                'Sello' => $this->getSello()
            ]
        );
    }

    /**
     * Get Certificado.
     *
     * @return string
     */
    protected function getCertificado(): string
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
            $this->comprobante->getElement(),
            [
                'Certificado' => $this->getCertificado()
            ]
        );
    }

    /**
     * Returns the xml with the stamp and certificate attributes.
     *
     * @return DOMDocument
     */
    protected function xml(): DOMDocument
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
    public function getXML(): string
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
    public function save(string $path, string $name)
    {
        $this->xml()->save($path.$name);
    }
}
