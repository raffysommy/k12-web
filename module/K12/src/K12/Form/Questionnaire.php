<?php

namespace K12\Form;

use K12\Entity\Questionnaire as QuestionnaireEntity;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;

class Questionnaire extends Form
{
	public function __construct()
	{
		parent::__construct('addQuestion');
		$this->setHydrator(new ClassMethods())
			 ->setObject(new QuestionnaireEntity());
		
		$this->add(
			array(
				'name' => 'name',
				'attributes' => array(
					'type' => 'text',
					'placeholder' => 'Nome',
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
					'value' => 'Crea',
					'class' => 'btn btn-primary'
				)
			)
		);
	}	
}