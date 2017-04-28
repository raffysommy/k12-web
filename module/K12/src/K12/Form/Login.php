<?php

namespace K12\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class Login extends Form
{
    public function __construct()
	{
		parent::__construct('login');
		
		$this->add(
			array(
				'name' => 'identity',
				'attributes' => array(
					'type' => 'text',
					'placeholder' => 'Username',
					'class' => 'form-control'
				),
				'filters' => array(
					'name' => 'StringTrim'
				),
				'required' => TRUE
			)
		);
		$this->add(
			array(
				'name' => 'password',
				'attributes' => array(
					'type' => 'password',
					'placeholder' => 'Password',
					'class' => 'form-control'
				),
				'filters' => array(
					'name' => 'StringTrim'
				),
				'required' => TRUE
			)
		);
		
		$this->add(
			array(
				'name' => 'csrf',
     			'type' => 'Zend\Form\Element\Csrf',
     			'options' => array(
             		'csrf_options' => array(
                    	'timeout' => 600
             		)
     			)
 			)
		);
		
		$this->add(
			array(
				'name' => 'submit',
				'attributes' => array(
					'type' => 'submit',
					'value' => 'Accedi',
					'class' => 'btn btn-primary btn-block btn-flat'
				)
			)
		);
	}
}

?>