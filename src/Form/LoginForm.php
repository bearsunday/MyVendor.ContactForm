<?php

namespace MyVendor\ContactForm\Form;

use Aura\Html\Helper\Tag;
use Ray\WebFormModule\AbstractAuraForm;
use Ray\WebFormModule\SetAntiCsrfTrait;

class LoginForm extends AbstractAuraForm
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
        /** @var $filter Filter */
        $filter = $this->getFilter();
        $filter->setRule(
            'user',
            'user id must be alphabetic only.',
            function ($value) {
                return ctype_alpha($value);
            }
        );
        $filter->setRule(
            'password',
            'password is required.',
            function ($value) {
                return strlen($value) > 0;
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function submit()
    {
        return $_POST['login'];
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