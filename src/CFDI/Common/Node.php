<?php

/*
 * This file is part of the CFDI project.
 *
 * (c) Orlando Charles <me@orlandocharles.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Charles\CFDI\Common;

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
     * Node document.
     *
     * @var \DOMDocument
     */
    protected $document;

    /**
     * Node element.
     *
     * @var \DOMElement
     */
    protected $element;

    /**
     * Node attributes.
     *
     * @var array
     */
    protected $attr = [];

    /**
     * Create a new node instance.
     *
     * @param array    $attr
     */
    public function __construct(...$attr)
    {
        $this->attr = $attr;

        $this->document = new DOMDocument('1.0', 'UTF-8');
        $this->document->preserveWhiteSpace = false;
        $this->document->formatOutput = true;

        $this->element = $this->document->createElement($this->getNodeName());
        $this->document->appendChild($this->element);
        $this->setAtributes($this->element, $this->getAttr());
    }

    /**
     *
     *
     * @return void
     */
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
                $this->setAtributes($parentElement, $node->getAttr('parent'));

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
     *
     *
     * @param DOMElement    $element
     * @param array         $attr
     */
    public function setAtributes(DOMElement $element, $attr)
    {
        if (!is_null($attr)) {
            foreach ($attr as $key => $value) {
                $value = preg_replace('/\s+/', ' ', $value); // Regla 5a y 5c
                $value = trim($value); // Regla 5b
                if (strlen($value) > 0) { // Regla 6
                    $value = str_replace("|", "/", $value); // Regla 1

                    $value = str_replace('&', '&amp;', $value);
                    $value = str_replace('<', '&lt;', $value);
                    $value = str_replace('>', '&gt;', $value);
                    $value = str_replace('"', '&quot;', $value);
                    $value = str_replace("'", '&apos;', $value);

                    $element->setAttribute($key, $value);
                }
            }
        }
    }

    /**
     * Get the element.
     *
     * @return \DOMElement
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * Get the document.
     *
     * @return \DOMElement
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Get the node attributes.
     *
     * @param string    $index
     *
     * @return array
     */
    public function getAttr($index = 'node')
    {
        $attrIndex = ['node', 'parent', 'wrapper'];

        if (in_array($index, $attrIndex)) {
            $index = array_search($index, $attrIndex);
        } else {
            $index = 0;
        }

        return (isset($this->attr[$index])) ? $this->attr[$index] : null;
    }

    /**
     * Get the parent node name.
     *
     * @return string|null
     */
    public function getParentNodeName()
    {
        return (isset($this->parentNodeName)) ? $this->parentNodeName : null;
    }

    /**
     * Get the node name.
     *
     * @return string
     */
    public function getNodeName()
    {
        return $this->nodeName;
    }
}
