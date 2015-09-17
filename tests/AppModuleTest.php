<?php

namespace MyVendor\ContactForm;

use BEAR\Package\Bootstrap;
use BEAR\Sunday\Extension\Application\AbstractApp;

class AppModuleTest extends \PHPUnit_Framework_TestCase
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
    public function testNewApp($contexts)
    {
        $app = (new Bootstrap())->getApp(__NAMESPACE__, $contexts);
        $this->assertInstanceOf(AbstractApp::class, $app);
    }
}
