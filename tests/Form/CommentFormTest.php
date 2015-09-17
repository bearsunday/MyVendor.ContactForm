<?php

namespace MyVendor\ContactForm;

use MyVendor\ContactForm\Form\CommentForm;
use Ray\WebFormModule\FormFactory;

class CommentFormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CommentForm
     */
    private $form;

    protected function setUp()
    {
        parent::setUp();
        /** @var $form CommentForm */
        $this->form = (new FormFactory)->newInstance(CommentForm::class);
    }

    public function testSetId()
    {
        $this->form->setId(1);
        $expected = '<input type="hidden" name="id" value="1" />';
        $this->assertContains($expected, (string) $this->form);
    }

    public function testApplyFailure()
    {
        $data = ['comment' => '@@invalid'];
        $success = $this->form->apply($data);
        $this->assertFalse($success);
    }

    public function testApplySuccess()
    {
        $data = ['comment' => 'nice'];
        $success = $this->form->apply($data);
        $this->assertTrue($success);
    }
}
