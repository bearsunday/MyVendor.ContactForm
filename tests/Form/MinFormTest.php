<?php
namespace MyVendor\ContactForm;

use MyVendor\ContactForm\Form\MinForm;
use PHPUnit\Framework\TestCase;
use Ray\WebFormModule\AbstractForm;
use Ray\WebFormModule\FormFactory;

class MinFormTest extends TestCase
{
    /**
     * @var AbstractForm
     */
    private $form;

    protected function setUp()
    {
        parent::setUp();
        /* @var $form MinForm */
        $this->form = (new FormFactory())->newInstance(MinForm::class);
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
