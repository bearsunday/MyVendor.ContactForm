<?php

namespace MyVendor\ContactForm;

use Aura\Filter\FilterFactory;
use Aura\Html\HelperLocatorFactory;
use Aura\Input\Builder;
use MyVendor\ContactForm\Form\CommentForm;

class CommentFormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CommentForm
     */
    private $form;

    protected function setUp()
    {
        parent::setUp();
        $this->form = new CommentForm;
        $this->form->setBaseDependencies(new Builder, new FilterFactory, new HelperLocatorFactory);
        $this->form->postConstruct();
    }

    public function testSetId()
    {
        $this->form->setId(1);
        $expected = '<input type="hidden" name="id" value="1" />';
        $this->assertContains($expected, (string)$this->form);
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
