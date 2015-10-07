<?php

namespace MyVendor\ContactForm\Form;

use Aura\Html\Helper\Tag;
use Ray\WebFormModule\AbstractForm;
use Ray\WebFormModule\SubmitInterface;

class LoginForm extends AbstractForm
{
    // use SetAntiCsrfTrait;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->setField('user')
            ->setAttribs([
                'id' => 'login[user]',
                'name' => 'login[user]',
                'size' => 8,
                'class' => 'form-control',
                'placeholder' => 'user name'
            ]);
        $this->setField('password', 'text')
            ->setAttribs([
                'id' => 'login[password]',
                'name' => 'login[password]',
                'class' => 'form-control',
                'placeholder' => 'Password'
            ]);
        $this->setField('submit', 'submit')
            ->setAttribs([
                'name' => 'submit',
                'value' => 'login'
            ]);
        // user
        $this->filter->validate('user')->is('alnum');
        $this->filter->useFieldMessage('user', 'user id must be alphabetic only.');
        // password
        $this->filter->validate('password')->isNot('blank');
        $this->filter->useFieldMessage('password', 'password is required.');
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $form = $this->form([
            'method' => 'post',
            'action' => '/multi'
        ]);
        // name
        /** @var $tag Tag */
        $tag  = $this->helper->get('tag');
        $form .= $tag('div', ['class' => 'form-group']);
        $form .= $tag('div', ['class' => 'form-group']);

        $form .= $this->helper->tag('div', ['class' => 'form-group']);
        $form .= $this->helper->tag('label', ['for' => 'name']);
        $form .= 'User ID:';
        $form .= $this->helper->tag('/label') . PHP_EOL;
        $form .= $this->input('user');
        $form .= $this->error('user');
        $form .= $this->helper->tag('/div') . PHP_EOL;
        // message
        $form .= $this->helper->tag('div', ['class' => 'form-group']);
        $form .= $this->helper->tag('label', ['for' => 'message']);
        $form .= 'Password:';
        $form .= $this->helper->tag('/label') . PHP_EOL;
        $form .= $this->input('password');
        $form .= $this->error('password');
        $form .= $this->helper->tag('/div') . PHP_EOL;
        // submit
        $form .= $this->input('submit');
        $form .= $this->helper->tag('/form');

        return $form;
    }
}
