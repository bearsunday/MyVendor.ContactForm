<?php

namespace MyVendor\ContactForm\Form;

use BEAR\Resource\Exception\BadRequestException;
use Ray\WebFormModule\AbstractForm;

class CommentFormList extends AbstractForm
{
    /**
     * @var CommentForm
     */
    private $form;

    /**
     * @var CommentForm[]
     */
    private $forms;

    /**
     * @var int[]
     */
    private $ids = [1, 2, 3, 4, 5];

    public function __construct(CommentForm $form)
    {
        $this->form = $form;
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        foreach ($this->ids as $id) {
            $form = clone $this->form;
            $form->setId($id);
            $this->forms[$id] = $form;
        }
    }

    public function apply(array $data)
    {
        if (! isset($data['id'])) {
            throw new BadRequestException('id');
        }
        $form = $this->forms[$data['id']];

        return $form->apply($data);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $forms = '';
        foreach ($this->forms as $form) {
            $forms .= (string) $form;
        }

        return $forms;
    }
}
