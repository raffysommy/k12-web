<?php

namespace K12\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use K12\Entity\Questionnaire as QuestionnaireEntity;
use K12\Entity\Question;

class AssignQuestionsToQuestionnaire extends Form
{
	/**
	 * @param array $questions
	 * @param array $questionnaires
	 */
	public function __construct(array $questions, array $questionnaires)
	{
		parent::__construct('assignQuestionsToQuestionnaire');
		
		/* Create questionnaire radio element */
		$questionnairesElement = new Element\Radio('questionnaire');
		$questionnairesElement->setValueOptions($this->getPreparedQuestionnaires($questionnaires));
		$this->add($questionnairesElement);
		
		/* Create questions select element */
		$questionsElement = new Element\Select('questions');
		$questionsElement->setValueOptions($this->getPreparedQuestions($questions));
		$questionsElement->setAttributes(array(
			'multiple' => 'multiple',
			'class' => 'form-control'
		));
		$this->add($questionsElement);
		
		$this->add(
				array(
						'name' => 'csrf',
						'type' => 'Zend\Form\Element\Csrf',
						'options' => array(
								'csrf_options' => array(
										'timeout' => 1800
								)
						)
				)
		);
		
		$submit = new Element\Submit('submit');
		$submit->setValue('Assegna')
			   ->setAttribute('class', 'btn btn-primary');
		$this->add($submit);
	}
	
	/**
	 * @param array $questionnaires
	 * @throws \InvalidArgumentException
	 * @return multitype:
	 */
	protected function getPreparedQuestionnaires(array $questionnaires)
	{
		$result = array();
		foreach ($questionnaires as $one)
			if (!$one instanceof QuestionnaireEntity)
				throw new \InvalidArgumentException('Questionnaires not properly provided');
			else 
				$result[$one->id] = $one->name;
		return $result;
	}
	
	protected function getPreparedQuestions(array $questions)
	{
		$result = array();
		foreach ($questions as $one)
			if (!$one instanceof Question)
				throw new \InvalidArgumentException('Questions not properly provided');
			else
				$result[$one->id] = substr($one->body, 0, 80);
		return $result;
	}
}