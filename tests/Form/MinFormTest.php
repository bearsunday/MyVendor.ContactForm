<?php
namespace MyVendor\ContactForm;

use BEAR\Package\AppInjector;
use MyVendor\ContactForm\Form\MinForm;
use PHPUnit\Framework\TestCase;
use Ray\WebFormModule\AbstractForm;

class MinFormTest extends TestCase
{
    /**
     * @var AbstractForm
     */
    private $form;

    protected function setUp()
    {
        $this->form = (new AppInjector('MyVendor\ContactForm', 'html-app'))->getInstance(MinForm::class);
        $this->form->init();
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
