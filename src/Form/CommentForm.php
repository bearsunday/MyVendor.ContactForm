<?php

namespace MyVendor\ContactForm\Form;

use Aura\Html\Helper\Tag;
use Ray\WebFormModule\AbstractForm;

class CommentForm extends AbstractForm
{
    // use SetAntiCsrfTrait;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->setField('comment')
            ->setAttribs([
                'id' => 'comment',
                'name' => 'comment'
            ]);
        $this->setField('submit', 'submit')
            ->setAttribs([
                'name' => 'submit',
                'value' => 'Submit'
            ]);
        $this->filter->validate('comment')->is('alnum');
        $this->filter->useFieldMessage('comment', 'Comment must be alphabetic only !!.');
    }

    public function setId($id)
    {
        $this->setField('id', 'hidden')
            ->setAttribs(['value' => $id]);
    }


    /**
     * {@inheritdoc}
     */
    public function submit()
    {
        return $_POST;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $form = $this->form([
            'method' => 'post',
            'action' => '/list'
        ]);
        // hidden
        $form .= $this->input('id');
        // name
        /** @var $tag Tag */
        $form .= $this->input('comment');
        $form .= $this->error('comment');
        // submit
        $form .= $this->input('submit');
        $form .= $this->helper->tag('/form');

        return $form;
    }
}