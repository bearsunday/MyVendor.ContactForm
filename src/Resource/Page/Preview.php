<?php
namespace MyVendor\ContactForm\Resource\Page;

use BEAR\Resource\ResourceObject;
use MyVendor\ContactForm\Form\PreviewForm;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;
use Ray\WebFormModule\Annotation\FormValidation;
use Ray\WebFormModule\FormInterface;

class Preview extends ResourceObject
{
    /**
     * @var PreviewForm
     */
    protected $form;

    /**
     * @param FormInterface $form
     *
     * @Inject
     * @Named("preview")
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
    public function onPost(string $name, string $number, string $is_preview = '0') : ResourceObject
    {
        if ($is_preview) {
            $this->code = 100; // continue
            $data = [
                'name' => $name,
                'number' => $number
            ];
            $this['form'] = $this->form->getHiddenForm($data);
            $this->form->setValues($this);

            return $this;
        }
        $this->code = 201; // created
        $this['name'] = $name;
        $this['number'] = $number;

        return $this;
    }

    public function onPostValidationFailed() : ResourceObject
    {
        $this->code = 400;

        return $this->onGet();
    }
}
