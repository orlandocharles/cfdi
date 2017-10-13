<?php
/*
 * This file is part of the eclipxe/cfdi library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Carlos C Soto <eclipxe13@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @link https://github.com/eclipxe13/cfdi GitHub
 * @link https://github.com/orlandocharles/cfdi Original project
 */
namespace PhpCfdi\CFDITests\Common;

use DOMDocument;
use DOMElement;
use PhpCfdi\CFDI\Common\Node;
use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase
{
    public function newFakeNode(...$attributes)
    {
        return new class(...$attributes) extends Node {
            protected $nodeName = 'Fake';
        };
    }

    public function newWithParent(...$attributes)
    {
        return new class(...$attributes) extends Node {
            protected $parentNodeName = 'Parent';
            protected $nodeName = 'Node';
        };
    }

    public function newWithParentWrapper(...$attributes)
    {
        return new class(...$attributes) extends Node {
            protected $wrapperNodeName = 'GrandParent';
            protected $parentNodeName = 'Parent';
            protected $nodeName = 'Node';
        };
    }

    public function testConstruct()
    {
        $node = $this->newFakeNode();

        $this->assertInstanceOf(Node::class, $node);
        $this->assertInstanceOf(DOMDocument::class, $node->getDocument());
        $this->assertInstanceOf(DOMElement::class, $node->getElement());
        $this->assertEquals('Fake', $node->getNodeName());
        $this->assertCount(0, $node->getAttr());
        $this->assertSame('', $node->getParentNodeName());
        $this->assertSame('', $node->getWrapperNodeName());
    }

    public function testConstructWithBadNodeImplementation()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessageRegExp('/El nodo de la clase .* no tiene nombre de nodo/');

        new class() extends Node {
            protected $nodeName = '';
        };
    }

    public function testGetDocumentReturnsAlwaysTheSameInstance()
    {
        $node = $this->newFakeNode();

        $first = $node->getDocument();
        $second = $node->getDocument();

        $this->assertSame($first, $second);
    }

    public function testGetElementReturnsAlwaysTheSameInstance()
    {
        $node = $this->newFakeNode();

        $first = $node->getElement();
        $second = $node->getElement();

        $this->assertSame($first, $second);
    }

    public function testGetElementIsTheRootOfTheDocument()
    {
        $node = $this->newFakeNode();

        $document = $node->getDocument();
        $element = $node->getElement();

        $this->assertSame($document->documentElement, $element);
        $this->assertSame($document, $element->ownerDocument);
    }

    public function testConstructWithAttributes()
    {
        $nodeAttributes = ['level' => 'node'];
        $parentAttributes = ['level' => 'parent'];
        $wrapperAttributes = ['level' => 'wrapper'];
        $node = $this->newFakeNode(
            $nodeAttributes,
            $parentAttributes,
            $wrapperAttributes
        );

        $this->assertEquals($nodeAttributes, $node->getAttr());
        $this->assertEquals($nodeAttributes, $node->getAttr('foo'));
        $this->assertEquals($nodeAttributes, $node->getAttr('node'));
        $this->assertEquals($parentAttributes, $node->getAttr('parent'));
        $this->assertEquals($wrapperAttributes, $node->getAttr('wrapper'));
    }

    public function testSetAttributes()
    {
        $node = $this->newFakeNode(['first' => 1]);
        $expectedXmlConstructor = '<Fake first="1"/>';
        $this->assertXmlStringEqualsXmlString($expectedXmlConstructor, $node->getDocument()->saveXML());

        $node->setAttributes($node->getElement(), ['second' => '2']);
        $expectedXmlAfterSet = '<Fake first="1" second="2"/>';
        $this->assertXmlStringEqualsXmlString($expectedXmlAfterSet, $node->getDocument()->saveXML());

        $node->setAttributes($node->getElement(), [
            'first' => '1.1',
            'second' => '1.2',
        ]);
        $expectedXmlOverride = '<Fake first="1.1" second="1.2"/>';
        $this->assertXmlStringEqualsXmlString($expectedXmlOverride, $node->getDocument()->saveXML());
    }

    public function testAddWithoutParents()
    {
        $inner = $this->newFakeNode(['name' => 'inner']);
        $node = $this->newFakeNode(['name' => 'node']);
        $node->add($inner);

        $expected = '<Fake name="node"><Fake name="inner"/></Fake>';
        $this->assertXmlStringEqualsXmlString($expected, $node->getDocument()->saveXML());
    }

    public function testAddWithParent()
    {
        $withParent = $this->newWithParent(['level' => 'node'], ['level' => 'parent']);
        $node = $this->newFakeNode();
        $node->add($withParent);
        $expected = '<Fake><Parent level="parent"><Node level="node"/></Parent></Fake>';
        $this->assertXmlStringEqualsXmlString($expected, $node->getDocument()->saveXML());
    }

    public function testAddWithParents()
    {
        $nodeAttributes = ['level' => 'node'];
        $parentAttributes = ['level' => 'parent'];
        $wrapperAttributes = ['level' => 'wrapper'];
        $node = $this->newFakeNode();
        $node->add($this->newWithParentWrapper(
            $nodeAttributes,
            $parentAttributes,
            $wrapperAttributes
        ));

        $expected = <<<EOT
<Fake><GrandParent level="wrapper"><Parent level="parent"><Node level="node"/></Parent></GrandParent></Fake>
EOT;

        $this->assertXmlStringEqualsXmlString($expected, $node->getDocument()->saveXML());
    }

    public function testAddSecondNodeWithParents()
    {
        $node = $this->newFakeNode();
        $node->add($this->newWithParentWrapper(['name' => 'first']));
        $node->add($this->newWithParentWrapper(['name' => 'second']));
        $expected = <<<EOT
<Fake>
    <GrandParent>
        <Parent>
            <Node name="first"/>
            <Node name="second"/>
        </Parent>
    </GrandParent>
</Fake>
EOT;
        $this->assertXmlStringEqualsXmlString($expected, $node->getDocument()->saveXML());
    }

    public function testAddWithContents()
    {
        $struct = $this->newWithParentWrapper(['name' => 'outer']);
        $struct->add(
            $this->newWithParentWrapper(['name' => 'inner'])
        );
        $node = $this->newFakeNode();
        $node->add($struct);
        $expected = <<<EOT
<Fake>
    <GrandParent>
        <Parent>
            <Node name="outer">
                <GrandParent>
                    <Parent>
                        <Node name="inner"/>
                    </Parent>
                </GrandParent>
            </Node>
        </Parent>
    </GrandParent>
</Fake>
EOT;
        $this->assertXmlStringEqualsXmlString($expected, $node->getDocument()->saveXML());
    }
}
