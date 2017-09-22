<?php
namespace MyVendor\ContactForm\Resource\Page;

use BEAR\Resource\ResourceObject;
use Ray\Di\Di\Named;
use Ray\WebFormModule\Annotation\FormValidation;
use Ray\WebFormModule\FormInterface;

class Multi extends ResourceObject
{
    /**
     * @var FormInterface
     */
    protected $contactForm;

    /**
     * @var FormInterface
     */
    protected $loginForm;

    /**
     * @Named("contactForm=contact_form, loginForm=login_form")
     */
    public function __construct(FormInterface $contactForm, FormInterface $loginForm)
    {
        $this->contactForm = $contactForm;
        $this->loginForm = $loginForm;
    }

    public function onGet()
    {
        $this['contact_form'] = $this->contactForm;
        $this['login_form'] = $this->loginForm;

        return $this;
    }

    public function onPost($submit, $contact = [], $login = []) : ResourceObject
    {
        if ($submit === 'contact') {
            return $this->contactForm($contact['name'], $contact['message']);
        }
        if ($submit === 'login') {
            return $this->login($login['user'], $login['password']);
        }
    }

    /**
     * @FormValidation(form="contactForm", onFailure="onFailure")
     */
    public function contactForm(string $name, string $message) : ResourceObject
    {
        $this->code = 201;
        $this['action'] = 'contact';
        $this['name'] = $name;
        $this['message'] = $message;

        return $this;
    }

    /**
     * @FormValidation(form="loginForm", onFailure="onFailure")
     */
    public function login(string $user, string $password) : ResourceObject
    {
        $this->code = 200;
        $this['action'] = 'login';
        $this['user'] = $user;
        $this['password'] = $password;

        return $this;
    }

    public function onFailure() : ResourceObject
    {
        $this->code = 400;

        return $this->onGet();
    }
}
