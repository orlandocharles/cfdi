<?php

/*
 * This file is part of the eclipxe13/cfdi library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Carlos C Soto <eclipxe13@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @link https://github.com/eclipxe13/cfdi GitHub
 * @link https://github.com/orlandocharles/cfdi Original project
 */
namespace PhpCfdi\CFDI;

use CfdiUtils\CadenaOrigen;
use CfdiUtils\Certificado;
use DOMDocument;
use PhpCfdi\CFDI\Common\Node;
use PhpCfdi\CFDI\Node\Comprobante;

/**
 * This is the cfdi class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
class CFDI
{
    /**
     * SAT XSL endpoint.
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
    protected $key = '';

    /**
     * CSD cer.
     *
     * @var string
     */
    protected $cer = '';

    /**
     * Comprobante instance.
     *
     * @var Comprobante
     */
    protected $comprobante;

    /** @var XmlResolver */
    protected $resolver;

    /**
     * Create a new cfdi instance.
     *
     * @param array         $data
     * @param XmlResolver   $resolver
     */
    public function __construct(array $data, XmlResolver $resolver = null)
    {
        $this->comprobante = new Comprobante($data, $this->version);
        $this->resolver = $resolver ? : new XmlResolver('');
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
        $this->comprobante->setAttributes(
            $this->comprobante->getElement(),
            [
                'NoCertificado' => $certificado->getSerial(),
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
        $location = $this->resolver->resolve(static::XSL_ENDPOINT, 'XSLT');
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
     * Put the stamp on the invoice.
     *
     * @return void
     */
    protected function putSello()
    {
        $this->comprobante->setAttributes(
            $this->comprobante->getElement(),
            [
                'Sello' => $this->getSello(),
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
     * Put the certificate on the invoice.
     *
     * @return void
     */
    protected function putCertificado()
    {
        $this->comprobante->setAttributes(
            $this->comprobante->getElement(),
            [
                'Certificado' => $this->getCertificado(),
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
     * Save the invoice into a file composed by path and name.
     *
     * @param string $filename
     *
     * @return void
     */
    public function save(string $filename)
    {
        $this->xml()->save($filename);
    }

    public function setResolver(XmlResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function getResolver(): XmlResolver
    {
        return $this->resolver;
    }

    public function getPrivateKey(): string
    {
        return $this->key;
    }

    /**
     * Set the private key (MUST be a PEM file contents)
     *
     * @param string $key file contents or the path of the file
     */
    public function setPrivateKey(string $key)
    {
        if ('' !== $key && ! $this->isPrivateKey($key)) {
            throw new \UnexpectedValueException('Invalid private key');
        }
        $this->key = $key;
    }

    public function isPrivateKey(string $key): bool
    {
        $prefix = '-----BEGIN PRIVATE KEY-----';
        $postfix = '-----END PRIVATE KEY-----';
        $postLength = strlen($postfix);
        $preLength = strlen($prefix);
        $key = trim($key);
        if (strlen($key) < $preLength + $postLength + 1000) {
            return false;
        }
        if (0 !== strpos($key, $prefix)) {
            return false;
        }
        if ($postfix !== substr($key, -$postLength)) {
            return false;
        }
        $contents = str_replace(["\r", "\n"], '', $key);
        $contents = substr($contents, $preLength, strlen($contents) - $preLength - $postLength);
        if (false === base64_decode($contents, true)) {
            return false;
        }
        return true;
    }

    public function __toString(): string
    {
        return $this->getXML();
    }
}
