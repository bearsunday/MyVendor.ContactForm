<?php

namespace MyVendor\ContactForm\Resource\Page;

use BEAR\Resource\ResourceObject;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;
use Ray\WebFormModule\AbstractAuraForm;
use Ray\WebFormModule\Annotation\FormValidation;
use Ray\WebFormModule\FormInterface;

class Loop extends ResourceObject
{
    /**
     * @var \Ray\WebFormModule\FormInterface
     */
    protected $form;

    /**
     * @param FormInterface $form
     *
     * @Inject
     * @Named("loop")
     */
    public function __construct(FormInterface $form)
    {
        $this->form = $form;
    }

    public function onGet()
    {
        $this['form'] = $this->form;

        return $this;
    }

    /**
     * @FormValidation
     *
     * @param $name
     *
     * @return $this
     */
    public function onPost($comment, $id)
    {
        $this->code = 201;
        $this['comment'] = $comment;

        return $this;
    }

    public function onPostValidationFailed()
    {
        $this->code = 400;

        return $this->onGet();
    }
}
