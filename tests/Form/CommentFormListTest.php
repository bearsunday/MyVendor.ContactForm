<?php
namespace MyVendor\ContactForm;

use BEAR\Package\AppInjector;
use BEAR\Resource\Exception\BadRequestException;
use MyVendor\ContactForm\Form\CommentForm;
use MyVendor\ContactForm\Form\CommentFormList;
use PHPUnit\Framework\TestCase;

class CommentFormListTest extends TestCase
{
    /**
     * @var CommentFormList
     */
    private $form;

    protected function setUp() : void
    {
        $form = (new AppInjector('MyVendor\ContactForm', 'html-app'))->getInstance(CommentForm::class);
        $form->init();
        $this->form = new CommentFormList($form);
        $this->form->init();
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
        $expected = '<input type="hidden" name="id" value="2" />
<input id="comment" type="text" name="comment" value="@@invalid" />
Comment must be alphabetic only ! ';
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

    public function testApplyNoId()
    {
        $this->expectException(BadRequestException::class);
        $data = [
            'comment' => 'nice'
        ];
        $this->form->apply($data);
    }
}
