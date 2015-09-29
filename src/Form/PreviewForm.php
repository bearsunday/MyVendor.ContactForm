<?php

namespace MyVendor\ContactForm\Form;

use Aura\Html\Helper\Tag;
use BEAR\Resource\ResourceObject;
use Ray\WebFormModule\AbstractForm;

class PreviewForm extends AbstractForm
{
    // use SetAntiCsrfTrait;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->setField('is_preview', 'hidden')
             ->setValue("1");
        $this->setField('name[0]');
        $this->setField('name[1]');

        $this->setField('number', 'radio')
             ->setValue('10')
             ->setOptions([
                 '10' => 'ten',
                 '20' => 'twenty',
                 '30' => 'thirty'
             ])
             ->setAttribs([
                 'id' => 'number',
                 'name' => 'number',
                 'size' => 20,
             ]);

        $this->setField('submit', 'submit')
            ->setAttribs([
                'name' => 'submit',
                'value' => 'Submit'
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $html = $this->form([ 'action' => '/preview']);
        // is_preview
        $html .= $this->input('is_preview');
        // name
        /* @var $tag Tag */
        $html .= $this->inputGroup('name[0]', 'Name0');
        $html .= $this->inputGroup('name[1]', 'Name1');
        $html .= $this->inputGroup('number', 'Number');
        // submit
        $html .= $this->input('submit');
        $html .= $this->helper->tag('/form');

        return $html;
    }

    /**
     * @param ResourceObject $ro
     *
     * @throws \Aura\Input\Exception\NoSuchInput
     */
    public function setValues(ResourceObject $ro)
    {
        $input = $this->getValue(); // input values
        $ro['name[0]'] = $input['name[0]'];
        $ro['name[1]'] = $input['name[1]'];
        // number
        $number = $this->get('number');
        $ro['number'] = $number["options"][$number["value"]]; // radio
    }

    /**
     * @param array $elementes
     *
     * @throws \Aura\Input\Exception\NoSuchInput
     */
    public function getHiddenForm()
    {
        $values = $this->getValue();
        $values['is_preview'] = '0';
        /** @var $tag Tag */
        $tag = $this->helper->get('tag');
        $html = $this->form([ 'action' => '/preview']);
        foreach ($values as $name => $value) {
            $html .= $this->helper->input([
                'type'    => 'hidden',
                'name'    => $name,
                'value'   => $value,
                'attribs' => []
            ]);
        }
        $html .= $this->input('submit');
        $html .= $tag('/form');

        return $html;
    }

    /**
     * @param $tag
     * @param $form
     *
     * @return string
     */
    private function inputGroup($input, $label)
    {
        /** @var $tag Tag */
        $tag = $this->helper->get('tag');
        $html = $tag('div', ['class' => 'form-group']);
        $html .= $tag('label', ['for' => $input]);
        $html .= $label;
        $html .= $tag('/label') . PHP_EOL;
        $html .= $this->input($input);
        $html .= $this->error($input);
        $html .= $tag('/div') . PHP_EOL;

        return $html;
    }
}
