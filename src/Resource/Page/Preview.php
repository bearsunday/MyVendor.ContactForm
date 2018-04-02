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
     *
     * @param mixed $name
     * @param mixed $number
     * @param mixed $is_preview
     */
    public function onPost($name, $number, array $interests, $is_preview = '0') : ResourceObject
    {
        if ($is_preview !== '0') {
            $data = [
                'name' => $name,
                'number' => $number,
                'interests' => $interests
            ];
            $this->body = [
                'form' => $this->form->getHiddenForm(),
                'is_preview' => 1
            ];
            $this->form->setValues($this);

            return $this;
        }
        $this->code = 201; // created
        $this->body = [
            'name' => $name,
            'number' => $number,
            'interests' => $interests
        ];

        return $this;
    }

    public function onPostValidationFailed() : ResourceObject
    {
        $this->code = 400;

        return $this->onGet();
    }
}
