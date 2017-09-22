<?php
namespace MyVendor\ContactForm\Form;

use Aura\Html\Helper\Tag;
use Ray\WebFormModule\AbstractForm;

class CommentForm extends AbstractForm
{
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $form = $this->form([
            'method' => 'post',
            'action' => '/loop'
        ]);
        // hidden
        $form .= $this->input('id');
        // name
        /* @var $tag Tag */
        $form .= $this->input('comment');
        $form .= $this->error('comment');
        // submit
        $form .= $this->input('submit');
        $form .= $this->helper->tag('/form');
        $form .= PHP_EOL . PHP_EOL;

        return $form;
    }

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
        $this->filter->useFieldMessage('comment', 'Comment must be alphabetic only ! ');
    }

    public function setId(string $id)
    {
        $this->setField('id', 'hidden')
            ->setValue((string) $id);
    }
}
