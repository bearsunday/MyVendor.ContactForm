<?php
namespace MyVendor\ContactForm;

use BEAR\Package\AppInjector;
use MyVendor\ContactForm\Form\PreviewForm;
use PHPUnit\Framework\TestCase;

class PreviewFormTest extends TestCase
{
    /**
     * @var PreviewForm
     */
    private $form;

    protected function setUp() : void
    {
        $this->form = (new AppInjector('MyVendor\ContactForm', 'html-app'))->getInstance(PreviewForm::class);
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
