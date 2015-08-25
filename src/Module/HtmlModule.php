<?php

namespace MyVendor\ContactForm\Module;

use Madapaja\TwigModule\TwigModule;
use Ray\Di\AbstractModule;
use Ray\WebFormModule\WebFormModule;

class HtmlModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->install(new TwigModule());
    }
}
