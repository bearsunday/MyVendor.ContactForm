<?php
namespace MyVendor\ContactForm;

use BEAR\Package\AppInjector;
use MyVendor\ContactForm\Form\LoginForm;
use PHPUnit\Framework\TestCase;

class LoginFormTest extends TestCase
{
    /**
     * @var LoginForm
     */
    private $form;

    protected function setUp()
    {
        $this->form = (new AppInjector('MyVendor\ContactForm', 'html-app'))->getInstance(LoginForm::class);
        $this->form->init();
    }

    public function testApplySuccess()
    {
        $data = [
            'user' => 'bear',
            'password' => '1234'
        ];
        $success = $this->form->apply($data);
        $this->assertTrue($success);
    }

    public function testApplyFailure()
    {
        $data = [
            'user' => '',
            'password' => ''
        ];
        $success = $this->form->apply($data);
        $this->assertFalse($success);
        $messages = $this->form->getFailureMessages();
        $this->assertArrayHasKey('user', $messages);
        $this->assertArrayHasKey('password', $messages);
    }

    public function testString()
    {
        $html = (string) $this->form;
        $this->assertContains('<input id="login[user]" type="text" name="login[user]" size="8" class="form-control" placeholder="user name" />', $html);
        $this->assertContains('<input id="login[password]" type="text" name="login[password]" class="form-control" placeholder="Password" />', $html);
    }
}
