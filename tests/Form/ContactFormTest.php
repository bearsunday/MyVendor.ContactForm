<?php

namespace Form;

use Aura\Html\HelperLocatorFactory;
use Aura\Input\Builder;
use Aura\Input\Filter;
use MyVendor\ContactForm\Form\ContactForm;

class ContactFormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContactForm
     */
    private $form;

    protected function setUp()
    {
        parent::setUp();
        $this->form = new ContactForm(new Builder, new Filter);
        $this->form->setFormHelper(new HelperLocatorFactory);
    }

    protected function submit(array $data)
    {
        $this->form->fill($data);
        $pass = $this->form->filter();

        return $pass;
    }

    public function testValdationFailed()
    {
        $pass = $this->submit([]);
        $this->assertFalse($pass);
    }

    public function testValidationSuccess()
    {
        $pass = $this->submit([
            'name' => 'BEAR',
            'message'=> 'Hello'
        ]);
        $this->assertTrue($pass);
    }

    public function testHtml()
    {
        $html = (string) $this->form;
        $this->assertContains('<form method="post"', $html);
        $this->assertContains('<input id="name" type="text" name="name" size="20" maxlength="20"', $html);
    }
}
