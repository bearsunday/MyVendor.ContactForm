<?php
namespace MyVendor\ContactForm\Resource\Page;

use BEAR\Resource\ResourceObject;
use Ray\Di\Di\Named;
use Ray\WebFormModule\Annotation\FormValidation;
use Ray\WebFormModule\FormInterface;

class Min extends ResourceObject
{
    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @param FormInterface $form
     *
     * @Named("name")
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
     * @param mixed $name
     */
    public function onPost($name) : ResourceObject
    {
        $this->code = 201;
        $this['name'] = $name;

        return $this;
    }

    public function onPostValidationFailed() : ResourceObject
    {
        $this->code = 400;

        return $this->onGet();
    }
}
