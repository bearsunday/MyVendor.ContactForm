<?php

namespace MyVendor\ContactForm\Form;

use Aura\Html\Helper\Tag;
use Ray\WebFormModule\AbstractForm;
use Ray\WebFormModule\SubmitInterface;

class ContactForm extends AbstractForm
{
    //     use SetAntiCsrfTrait;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->setField('name')
            ->setAttribs([
                'id' => 'contact[name]',
                'name' => 'contact[name]',
                'size' => 20,
                'maxlength' => 20,
                'class' => 'form-control',
                'placeholder' => 'Your Name'
            ]);
        $this->setField('message', 'textarea')
            ->setAttribs([
                'id' => 'contact[message]',
                'name' => 'contact[message]',
                'cols' => 40,
                'rows' => 5,
                'class' => 'form-control',
                'placeholder' => 'Message here'
            ]);
        $this->setField('submit', 'submit')
            ->setAttribs([
                'name' => 'submit',
                'value' => 'contact'
            ]);
        // name
        $this->filter->validate('name')->isNot('blank');
        $this->filter->validate('name')->is('alnum');
        $this->filter->useFieldMessage('name', 'Name must be alphabetic only.');
        // message
        $this->filter->validate('message')->isNot('blank');
        $this->filter->useFieldMessage('message', 'Message is required.');
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
        $form .= 'Name:';
        $form .= $this->helper->tag('/label') . PHP_EOL;
        $form .= $this->input('name');
        $form .= $this->error('name');
        $form .= $this->helper->tag('/div') . PHP_EOL;
        // message
        $form .= $this->helper->tag('div', ['class' => 'form-group']);
        $form .= $this->helper->tag('label', ['for' => 'message']);
        $form .= 'Message:';
        $form .= $this->helper->tag('/label') . PHP_EOL;
        $form .= $this->input('message');
        $form .= $this->error('message');
        $form .= $this->helper->tag('/div') . PHP_EOL;
        // submit
        $form .= $this->input('submit');
        $form .= $this->helper->tag('/form');

        return $form;
    }
}
