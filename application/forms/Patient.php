<?php

class Application_Form_Patient extends Zend_Form
{
    public function init()
    {
        $this->setName('patient');

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Nome')
            ->setRequired(true)
            ->setAttrib('class', 'form-control')
            ->addValidator('NotEmpty');

        $gender = new Zend_Form_Element_Radio('gender');
        $gender->setLabel('Sexo')
            ->setRequired(true)
            ->setAttrib('class', 'form-radio')
            ->setMultiOptions([
                'male' => 'Masculino',
                'female' => 'Feminino',
            ])
            ->addValidator('NotEmpty');

        $dayOfBirth = new Zend_Form_Element_Text('dayOfBirth');
        $dayOfBirth->setLabel('Nascimento')
            ->setAttrib('type', 'date')
            ->setAttrib('class', 'form-control')
            ->setRequired(true)
            ->addValidator('regex', false, ['/^([0-9]{2}\/){2}[0-9]{4}$/']);

        $healthInsurance = new Zend_Form_Element_Text('healthInsurance');
        $healthInsurance->setLabel('Convênio')
            ->setAttrib('class', 'form-control');

        $submitButton = new Zend_Form_Element_Submit('submit');
        $submitButton->setAttrib('class', 'btn btn-primary');

        $this->addElements([$id, $name, $gender, $dayOfBirth, $healthInsurance, $submitButton]);
    }
}

