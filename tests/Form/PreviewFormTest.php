<?php

namespace MyVendor\ContactForm;

use MyVendor\ContactForm\Form\PreviewForm;
use MyVendor\ContactForm\Resource\Page\Preview;
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
        $this->form = (new FormFactory())->newInstance(PreviewForm::class);
    }

    public function testValdationFailed()
    {
    }

    public function testSet()
    {
        $this->form->apply(['name' => ['0' => 'hello']]);
        $ro = new Preview($this->form);
        $ro['name[0]'] = 'hello';
        $this->form->setValues($ro);
        $this->assertSame('hello', $ro['name']['0']);
    }
}
