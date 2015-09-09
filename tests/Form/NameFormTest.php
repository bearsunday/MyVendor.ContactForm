<?php

namespace MyVendor\ContactForm;

use Aura\Html\HelperLocatorFactory;
use Aura\Input\Builder;
use Aura\Input\Filter;
use MyVendor\ContactForm\Form\ContactForm;
use MyVendor\ContactForm\Form\NameForm;
use Ray\WebFormModule\AbstractForm;

class NameFormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractForm
     */
    private $form;

    protected function setUp()
    {
        parent::setUp();
        $this->form = new NameForm;
        $this->form->postConstruct();
    }

    public function testValdationFailed()
    {
        $isValid = $this->form->apply([]);
        $this->assertFalse($isValid);
    }

    public function testValidationSuccess()
    {
        $isValid = $this->form->apply([
            'name' => 'BEAR'
        ]);
        $this->assertTrue($isValid);
    }

    public function testHtml()
    {
        $html = (string) $this->form;
        $this->assertContains('<form method="post"', $html);
        $this->assertContains('<input id="name" type="text" name="name" size="20" maxlength="20"', $html);
    }
}
