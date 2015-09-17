<?php

namespace MyVendor\ContactForm\Module;

use BEAR\Package\Bootstrap;
use BEAR\Sunday\Extension\Application\AbstractApp;

class ModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Available contexts
     *
     * @dataProvider
     */
    public function contextsProvider()
    {
        return [
            ['app'],
            ['prod-html-app'],
            ['prod-hal-api-app'],
        ];
    }

    /**
     * @param string $contexts
     *
     * @dataProvider contextsProvider
     */
    public function testGetApp($contexts)
    {
        $app = (new Bootstrap())->getApp('MyVendor\ContactForm', $contexts);
        $this->assertInstanceOf(AbstractApp::class, $app);
    }
}
