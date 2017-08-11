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
use DOMNodeList;

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
     * Add a new node
     *
     * @return void
     */
    public function add($node)
    {
        $wrapperElement = null;

        $nodeElement = $this->document->createElement($node->getNodeName());
        $this->setAtributes($nodeElement, $node->getAttr());

        foreach ($node->element->childNodes as $child) {
            $nodeElement->appendChild(
                $this->document->importNode($child, true)
            );
        }

        if ($wrapperName = $node->getWrapperNodeName()) {
            $wrapperElement = $this->getDirectChildElementByName(
                $this->element->childNodes, $wrapperName
            );

            if (!$wrapperElement) {
                $wrapperElement = $this->document->createElement($wrapperName);
                $this->element->appendChild($wrapperElement);
                $this->setAtributes($wrapperElement, $node->getAttr('wrapper'));
            }
        }

        if ($parentName = $node->getParentNodeName()) {
            $currentElement = ($wrapperElement) ? $wrapperElement : $this->element ;

            $parentNode = $this->getDirectChildElementByName(
                $currentElement->childNodes, $parentName
            );

            if (!$parentNode) {
                $parentElement = $this->document->createElement($parentName);
                $currentElement->appendChild($parentElement);
                $parentElement->appendChild($nodeElement);
                $this->setAtributes($parentElement, $node->getAttr('parent'));

            } else {
                $parentNode->appendChild($nodeElement);
            }

        } else {
            $this->element->appendChild($nodeElement);
        }
    }

    /**
     * Search the direct child of an element
     *
     * @param DOMNodeList   $childs
     * @param string        $find
     *
     * @return DOMElement|null
     */
    protected function getDirectChildElementByName(DOMNodeList $childs, $find)
    {
        foreach ($childs as $child) {
            if ($child->nodeName == $find) {
                return $child;
            }
        }
        return null;
    }

    /**
     * Adds attributes to an element
     *
     * @param DOMElement    $element
     * @param array         $attr
     *
     * @return void
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
     * Get element.
     *
     * @return \DOMElement
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * Get document.
     *
     * @return \DOMElement
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Get node attributes.
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
     * Get wrapper node name.
     *
     * @return string|null
     */
    public function getWrapperNodeName()
    {
        return (isset($this->wrapperNodeName)) ? $this->wrapperNodeName : null;
    }

    /**
     * Get parent node name.
     *
     * @return string|null
     */
    public function getParentNodeName()
    {
        return (isset($this->parentNodeName)) ? $this->parentNodeName : null;
    }

    /**
     * Get node name.
     *
     * @return string
     */
    public function getNodeName()
    {
        return $this->nodeName;
    }
}
