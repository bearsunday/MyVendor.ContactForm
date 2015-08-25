<?php

namespace MyVendor\ContactForm\Resource\Page;

use Aura\Input\Form;
use BEAR\Resource\ResourceObject;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;
use Ray\WebFormModule\AbstractAuraForm;
use Ray\WebFormModule\Annotation\FormValidation;
use Ray\WebFormModule\FormInterface;

class Index extends ResourceObject
{
    /**
     * @var \Ray\WebFormModule\AbstractAuraForm
     */
    protected $form;

    /**
     * @param AbstractAuraForm $form
     *
     * @Inject
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
     * @FormValidation(form="form", onFailure="onFailure")
     *
     * @param $name
     *
     * @return $this
     */
    public function onPost($name)
    {
        $this->code = 201;
        $this['name'] = $name;

        return $this;
    }

    public function onFailure()
    {
        $this->code = 400;
        return $this->onGet();
    }
}
