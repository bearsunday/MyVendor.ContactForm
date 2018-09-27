<?php
namespace MyVendor\ContactForm;

use BEAR\Package\AppInjector;
use MyVendor\ContactForm\Form\ContactForm;
use PHPUnit\Framework\TestCase;

class ContactFormTest extends TestCase
{
    /**
     * @var ContactForm
     */
    private $form;

    protected function setUp()
    {
        $this->form = (new AppInjector('MyVendor\ContactForm', 'html-app'))->getInstance(ContactForm::class);
        $this->form->init();
    }

    public function testApplyFailure()
    {
        $data = [
            'name' => 'bear',
            'message' => ''
        ];
        $success = $this->form->apply($data);
        $this->assertFalse($success);
    }

    public function testApplySuccess()
    {
        $data = [
            'name' => 'bear',
            'message' => 'nice'
        ];
        $success = $this->form->apply($data);
        $this->assertTrue($success);
    }
}
