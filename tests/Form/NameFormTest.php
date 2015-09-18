<?php

namespace MyVendor\ContactForm;

use MyVendor\ContactForm\Form\NameForm;
use Ray\WebFormModule\AbstractForm;
use Ray\WebFormModule\FormFactory;

class NameFormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractForm
     */
    private $form;

    protected function setUp()
    {
        parent::setUp();
        /* @var $form NameForm */
        $this->form = (new FormFactory())->newInstance(NameForm::class);
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
