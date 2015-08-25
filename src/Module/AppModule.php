<?php

namespace MyVendor\ContactForm\Module;

use Aura\Input\Form;
use BEAR\Package\PackageModule;
use MyVendor\ContactForm\Form\ContactForm;
use Ray\Di\AbstractModule;
use Ray\WebFormModule\WebFormModule;

class AppModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->install(new PackageModule);
        $this->bind(Form::class)->annotatedWith('contact_form')->to(ContactForm::class);
        $this->install(new WebFormModule);
    }
}
