<?php

namespace MyVendor\ContactForm;

use MyVendor\ContactForm\Form\NameForm;
use MyVendor\ContactForm\Form\PreviewForm;
use Ray\WebFormModule\AbstractForm;
use Ray\WebFormModule\FormFactory;

class PreviewFormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PreviewForm
     */
    private $form;

    protected function setUp()
    {
        parent::setUp();
        /* @var $form NameForm */
        $this->form = (new FormFactory())->newInstance(PreviewForm::class);
    }

    public function testValdationFailed()
    {
        $isValid = $this->form->apply([]);
        $this->assertFalse($isValid);
    }

    public function testValidationSuccess()
    {
        $isValid = $this->form->apply([
            'name' => 'BEAR',
            'number' => '20'
        ]);
        $this->assertTrue($isValid);
    }

    public function testHtml()
    {
        $html = (string) $this->form;
        $this->assertContains('<form method="post"', $html);
        $this->assertContains('<input type="hidden" name="is_preview" value="1" />', $html);
        $this->assertContains('<input id="name" type="text" name="name" size="20" maxlength="20"', $html);
    }

    public function testHiddenForm()
    {
        $html = $this->form->getHiddenForm();
        $this->assertContains('<form method="post"', $html);
        $this->assertContains('<input type="hidden" name="is_preview" value="0" />', $html);
        $this->assertContains('<input type="hidden" name="name" />', $html);
        $this->assertContains('<input type="hidden" name="number" value="10" />', $html);
        $this->assertContains('<input type="submit" name="submit" value="Submit" />', $html);
    }
}
