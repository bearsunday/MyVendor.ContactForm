<?php

namespace MyVendor\ContactForm;

use Aura\Filter\FilterFactory;
use Aura\Html\HelperLocatorFactory;
use Aura\Input\Builder;
use MyVendor\ContactForm\Form\CommentForm;
use MyVendor\ContactForm\Form\CommentFormList;

class CommentFormListTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CommentForm
     */
    private $form;

    protected function setUp()
    {
        parent::setUp();
        $form = new CommentForm;
        $form->setBaseDependencies(new Builder, new FilterFactory, new HelperLocatorFactory);
        $form->postConstruct();
        $this->form = new CommentFormList($form);
        $this->form->postConstruct();
    }


    public function testString()
    {
        $html = (string) $this->form;
        $expected1 = '<input type="hidden" name="id" value="1" />';
        $expected2 = '<input type="hidden" name="id" value="2" />';
        $expected3 = '<input type="hidden" name="id" value="3" />';
        $expected4 = '<input type="hidden" name="id" value="4" />';
        $expected5 = '<input type="hidden" name="id" value="5" />';
        $this->assertContains($expected1, $html);
        $this->assertContains($expected2, $html);
        $this->assertContains($expected3, $html);
        $this->assertContains($expected4, $html);
        $this->assertContains($expected5, $html);
    }

    public function testApplyFailure()
    {
        $data = [
            'id' => 2,
            'comment' => '@@invalid'
        ];
        $success = $this->form->apply($data);
        $this->assertFalse($success);
        $html = (string) $this->form;
        // error message
        $expected = '<form method="post" action="/loop" enctype="multipart/form-data"><input type="hidden" name="id" value="2" />
<input id="comment" type="text" name="comment" />
Comment must be alphabetic only ! <input type="submit" name="submit" value="Submit" />
</form>';
        $this->assertContains($expected, $html);
        // no error message
        $expected = '<input type="hidden" name="id" value="1" />
<input id="comment" type="text" name="comment" />
<input type="submit" name="submit" value="Submit" />';
        $this->assertContains($expected, $html);
    }

    public function testApplySuccess()
    {
        $data = [
            'id' => 1,
            'comment' => 'nice'
        ];
        $success = $this->form->apply($data);
        $this->assertTrue($success);
    }
}

