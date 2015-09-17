<?php

namespace MyVendor\ContactForm\Module;

use BEAR\Package\PackageModule;
use MyVendor\ContactForm\Form\CommentForm;
use MyVendor\ContactForm\Form\CommentFormList;
use MyVendor\ContactForm\Form\ContactForm;
use MyVendor\ContactForm\Form\LoginForm;
use MyVendor\ContactForm\Form\NameForm;
use Ray\Di\AbstractModule;
use Ray\WebFormModule\AuraInputModule;
use Ray\WebFormModule\FormInterface;

class AppModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->install(new PackageModule);
        $this->install(new AuraInputModule);
        $this->bind(ContactForm::class);
        $this->bind(CommentForm::class);
        $this->bind(FormInterface::class)->annotatedWith('name')->to(NameForm::class);
        $this->bind(FormInterface::class)->annotatedWith('contact_form')->to(ContactForm::class);
        $this->bind(FormInterface::class)->annotatedWith('login_form')->to(LoginForm::class);
        $this->bind(FormInterface::class)->annotatedWith('loop')->to(CommentFormList::class);
    }
}
