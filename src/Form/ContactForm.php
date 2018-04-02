<?php
namespace MyVendor\ContactForm\Form;

use Aura\Html\Helper\Tag;
use Ray\WebFormModule\AbstractForm;

class ContactForm extends AbstractForm
{
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
        /* @var $tag Tag */
        $tag = $this->helper->get('tag');
        $form .= $tag('div', ['class' => 'form-group']);
        $form .= $tag('div', ['class' => 'form-group']);

        $form .= $tag('div', ['class' => 'form-group']);
        $form .= $tag('label', ['for' => 'name']);
        $form .= 'Name:';
        $form .= $tag('/label') . PHP_EOL;
        $form .= $this->input('name');
        $form .= $this->error('name');
        $form .= $tag('/div') . PHP_EOL;
        // message
        $form .= $tag('div', ['class' => 'form-group']);
        $form .= $tag('label', ['for' => 'message']);
        $form .= 'Message:';
        $form .= $tag('/label') . PHP_EOL;
        $form .= $this->input('message');
        $form .= $this->error('message');
        $form .= $tag('/div') . PHP_EOL;
        // submit
        $form .= $this->input('submit');
        $form .= $tag('/form');

        return $form;
    }

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
        $this->filter->validate('name')->isNotBlank();
        $this->filter->validate('name')->is('alnum');
        $this->filter->useFieldMessage('name', 'Name must be alphabetic only.');
        // message
        $this->filter->validate('message')->isNotBlank();
        $this->filter->useFieldMessage('message', 'Message is required.');
    }
}
