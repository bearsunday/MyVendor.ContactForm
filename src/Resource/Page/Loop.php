<?php
namespace MyVendor\ContactForm\Resource\Page;

use BEAR\Resource\ResourceObject;
use Ray\Di\Di\Named;
use Ray\WebFormModule\Annotation\FormValidation;
use Ray\WebFormModule\FormInterface;

class Loop extends ResourceObject
{
    /**
     * @var \Ray\WebFormModule\FormInterface
     */
    protected $form;

    /**
     * @Named("loop")
     */
    public function __construct(FormInterface $form)
    {
        $this->form = $form;
    }

    public function onGet() : ResourceObject
    {
        $this['form'] = $this->form;

        return $this;
    }

    /**
     * @FormValidation
     */
    public function onPost(string $comment, string $id) : ResourceObject
    {
        unset($id);
        $this->code = 201;
        $this->body = [
            'comment' => $comment
        ];

        return $this;
    }

    public function onPostValidationFailed() : ResourceObject
    {
        $this->code = 400;

        return $this->onGet();
    }
}
