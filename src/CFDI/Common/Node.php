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
abstract class Node
{
    /**
     * Define the node name.
     *
     * @var string
     */
    protected $nodeName = '';

    /**
     * Define the parent node name, rename this attribute in inherit class.
     *
     * @var string
     */
    protected $parentNodeName = '';

    /**
     * Define the wrapper node name (node grandparent), rename this attribute in inherit class
     * @var string
     */
    protected $wrapperNodeName = '';

    /**
     * Node document.
     *
     * @var DOMDocument
     */
    protected $document;

    /**
     * Node element.
     *
     * @var DOMElement
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
        $this->setAttributes($this->element, $this->getAttr());
    }

    /**
     * Add a new node.
     *
     * @param Node $node
     * @return void
     */
    public function add(Node $node)
    {
        // create the nodeElement with all contents
        $nodeElement = $this->document->createElement($node->getNodeName());
        $this->setAttributes($nodeElement, $node->getAttr());
        foreach ($node->element->childNodes as $child) {
            $nodeElement->appendChild(
                $this->document->importNode($child, true)
            );
        }

        // exit early if no parentName was found, just add to this element
        $parentName = $node->getParentNodeName();
        if (! $parentName) {
            $this->element->appendChild($nodeElement);
            return;
        }

        // get or create the wrapper element if needed
        $wrapperName = $node->getWrapperNodeName();
        if ($wrapperName) {
            $wrapperElement = $this->getDirectChildOrCreate($this->element, $wrapperName, $node->getAttr('wrapper'));
        } else {
            $wrapperElement = $this->element;
        }

        // get or create the parent element if needed
        $parentNode = $this->getDirectChildOrCreate($wrapperElement, $parentName, $node->getAttr('parent'));

        // append the created element
        $parentNode->appendChild($nodeElement);
    }

    protected function getDirectChildOrCreate(DOMElement $owner, string $name, array $attributes): DOMElement
    {
        $created = $this->getDirectChildElementByName(
            $owner->childNodes,
            $name
        );
        if (null === $created) {
            $created = $this->document->createElement($name);
            $owner->appendChild($created);
            $this->setAttributes($created, $attributes);
        }
        return $created;
    }

    /**
     * Search the direct child of an element.
     *
     * @param DOMNodeList   $children
     * @param string        $find
     *
     * @return DOMElement|null
     */
    protected function getDirectChildElementByName(DOMNodeList $children, string $find)
    {
        foreach ($children as $child) {
            if ($child->nodeName == $find) {
                return $child;
            }
        }
        return null;
    }

    /**
     * Adds attributes to an element.
     *
     * @param DOMElement    $element
     * @param array         $attr
     *
     * @return void
     */
    public function setAttributes(DOMElement $element, array $attr)
    {
        foreach ($attr as $key => $value) {
            $element->setAttribute($key, $value);
        }
    }

    /**
     * Get element.
     *
     * @return DOMElement
     */
    public function getElement(): DOMElement
    {
        return $this->element;
    }

    /**
     * Get document.
     *
     * @return DOMDocument
     */
    public function getDocument(): DOMDocument
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
    public function getAttr(string $index = 'node'): array
    {
        $attrIndex = ['node', 'parent', 'wrapper'];
        $index = (int) array_search($index, $attrIndex);
        return (isset($this->attr[$index])) ? $this->attr[$index] : [];
    }

    /**
     * Get wrapper node name.
     *
     * @return string
     */
    public function getWrapperNodeName(): string
    {
        return $this->wrapperNodeName;
    }

    /**
     * Get parent node name.
     *
     * @return string
     */
    public function getParentNodeName(): string
    {
        return $this->parentNodeName;
    }

    /**
     * Get node name.
     *
     * @return string
     */
    public function getNodeName(): string
    {
        if (! is_string($this->nodeName) || '' === $this->nodeName) {
            throw new \LogicException('El nodo de la clase ' . get_class($this) . ' no tiene nombre de nodo');
        }
        return $this->nodeName;
    }
}
