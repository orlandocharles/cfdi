<?php

namespace Charles\CFDITests;

use Charles\CFDI\CFDI;
use PHPUnit\Framework\TestCase;

/**
 * This class exists as an example of the testing environment,
 * once tests are created feel free to remove it
 */
class TestEnvironmentTest extends TestCase
{
    public function testClassCfdiExists()
    {
        $this->assertTrue(class_exists(CFDI::class));
    }
}
