<?php
namespace MyVendor\ContactForm;

use BEAR\Package\AppInjector;
use MyVendor\ContactForm\Form\CommentForm;
use PHPUnit\Framework\TestCase;

class CommentFormTest extends TestCase
{
    /**
     * @var CommentForm
     */
    private $form;

    protected function setUp()
    {
        $this->form = (new AppInjector('MyVendor\ContactForm', 'html-app'))->getInstance(CommentForm::class);
        $this->form->init();
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
