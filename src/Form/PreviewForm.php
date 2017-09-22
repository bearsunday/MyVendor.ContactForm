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
        $html .= $this->inputGroup('interests', 'Interests');
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
            // value => label
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

        $this->setField('interests', 'checkbox')
            ->setValue('yes')
            // value => label
            ->setOptions([
                'tech' => 'Tech',
                'travel' => 'Travel',
                'art' => 'Art'
            ])
            ->setAttribs([
            'id' => 'interests',
            'name' => 'interests'
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
        $ro->body['name'] = $input['name'];
        // number
        $number = $this->get('number');
        $interests = $this->get('interests');
        $ro->body['number'] = $number['options'][$number['value']]; // radio
        $ro->body['interests'] = $this->getCheckedBoxLabel($interests['options'], $interests['value']); // checkbox
    }

    /**
     * Return checked box label array
     *
     * ex) ["Travel", "Art] not ["travel", "art] when "Travel" and "Art" are checked
     */
    private function getCheckedBoxLabel(array $options, array $values) : array
    {
        $result = [];
        foreach ($values as $value) {
            if (isset($options[$value])) {
                $result[] = $options[$value];
            }
        }

        return $result;
    }

    public function getHiddenForm() : string
    {
        $values = $this->getValue();
        $values['is_preview'] = '0';
        /* @var $tag Tag */
        $tag = $this->helper->get('tag');
        $html = $this->form(['action' => '/preview']);
        foreach ($values as $name => $value) {
            if (is_array($value)) {
                $html .= $this->getSelectbox($value, $name);
                continue;
            }
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

    private function getSelectbox(array $values, string $name): string
    {
        $html = '';
        foreach ($values as $value) {
            $html .= $this->helper->input([
                'type' => 'hidden',
                'name' => $name . '[]',
                'value' => $value,
                'attribs' => []
            ]);
        }

        return $html;
    }
}
