<?php
namespace MyVendor\ContactForm\Form;

use Aura\Html\Helper\Tag;
use BEAR\Resource\ResourceObject;
use Ray\WebFormModule\AbstractForm;

class PreviewForm extends AbstractForm
{
    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $html = $this->form(['action' => '/preview']);
        // is_preview
        $html .= $this->input('is_preview');
        // name
        /* @var $tag Tag */
        $html .= $this->inputGroup('name', 'Name');
        $html .= $this->inputGroup('number', 'Number');
        // submit
        $html .= $this->input('submit');
        $html .= $this->helper->tag('/form');

        return $html;
    }

    // use SetAntiCsrfTrait;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->setField('is_preview', 'hidden')
             ->setValue('1');
        $this->setField('name')
            ->setAttribs([
                'id' => 'name',
                'name' => 'name',
                'size' => 20,
                'maxlength' => 20,
                'class' => 'form-control',
                'placeholder' => 'Your Name'
            ]);
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
        $this->filter->validate('name')->isNotBlank();
        $this->filter->validate('name')->is('alnum');
        $this->filter->useFieldMessage('name', 'Name must be alphabetic only !!.');
    }

    public function setValues(ResourceObject $ro)
    {
        $input = $this->getValue(); // input values
        $ro['name'] = $input['name'];
        // number
        $number = $this->get('number');
        $ro['number'] = $number['options'][$number['value']]; // radio
    }

    public function getHiddenForm() : string
    {
        $values = $this->getValue();
        $values['is_preview'] = '0';
        /* @var $tag Tag */
        $tag = $this->helper->get('tag');
        $html = $this->form(['action' => '/preview']);
        foreach ($values as $name => $value) {
            $html .= $this->helper->input([
                'type' => 'hidden',
                'name' => $name,
                'value' => $value,
                'attribs' => []
            ]);
        }
        $html .= $this->input('submit');
        $html .= $tag('/form');

        return $html;
    }

    private function inputGroup(string $input, string $label) : string
    {
        /* @var $tag Tag */
        $tag = $this->helper->get('tag');
        $html = $tag('div', ['class' => 'form-group']);
        $html .= $tag('div', ['class' => 'form-group']);
        $html .= $tag('label', ['for' => $input]);
        $html .= $label;
        $html .= $tag('/label') . PHP_EOL;
        $html .= $this->input($input);
        $html .= $this->error($input);
        $html .= $tag('/div') . PHP_EOL;

        return $html;
    }
}
