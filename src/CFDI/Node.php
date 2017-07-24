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

use DOMDocument;
use DOMElement;

/**
 * This is the node class.
 *
 * @author Orlando Charles <me@orlandocharles.com>
 */
class Node
{
    /**
     * @var \DOMDocument
     */
    protected $document;

    /**
     * @var \DOMElement
     */
    protected $element;

    /**
     * @var array
     */
    protected $attr;

    /**
     * @param array    $attr
     */
    public function __construct(array $attr)
    {
        $this->attr = $attr;

        $this->document = new DOMDocument('1.0', 'UTF-8');
        $this->document->preserveWhiteSpace = false;
        $this->document->formatOutput = true;

        $this->element = $this->document->createElement($this->getNodeName());
        $this->document->appendChild($this->element);
        $this->setAtributes($this->element, $this->getAttr());
    }

    public function add($node)
    {
        $nodeElement = $this->document->createElement($node->getNodeName());
        $this->setAtributes($nodeElement, $node->getAttr());

        if ($parentName = $node->getParentNodeName()) {
            $parentNode = $this->document->getElementsByTagName($parentName);

            if ($parentNode->length == 0) {
                $parentElement = $this->document->createElement($parentName);
                $this->element->appendChild($parentElement);
                $parentElement->appendChild($nodeElement);

            } else {
                $parentNode->item(0)->appendChild($nodeElement);
            }

        } else {
            $this->element->appendChild($nodeElement);
        }

        foreach ($node->element->childNodes as $child) {
            $nodeElement->appendChild(
                $this->document->importNode($child, true)
            );
        }
    }

    /**
     * @param DOMElement    $element
     * @param array         $attr
     */
    public function setAtributes(DOMElement $element, array $attr)
    {
        foreach ($attr as $key => $value) {
            $element->setAttribute($key, $value);
        }
    }

    /**
     * @return \DOMElement
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * @return \DOMElement
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @return array
     */
    public function getAttr()
    {
        return $this->attr;
    }

    /**
     * @return string|null
     */
    public function getParentNodeName()
    {
        return (isset($this->parentNodeName)) ? $this->parentNodeName : null;
    }

    /**
     * @return string
     */
    public function getNodeName()
    {
        return $this->nodeName;
    }
}
