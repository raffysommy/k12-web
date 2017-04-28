<?php

namespace K12\Controller;

use K12\Form\Questionnaire;
use Zend\Db\Adapter\Adapter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use K12\Entity\Question;
use K12\Entity\Questionnaire as QuestionnaireEntity;
use K12\Form\AssignQuestionsToQuestionnaire;

class QuestionnaireController extends AbstractActionController
{
	public function indexAction()
	{
		$form = new Questionnaire();
		$viewModel = new ViewModel(array('addForm' => $form));
		
		$requestQuestions = $this->getServiceLocator()->get('k12-api')->sendRequest('/api/question/list');
		$requestQuestionnaires = $this->getServiceLocator()->get('k12-api')->sendRequest('/api/questionnaire/list');
		$questions = array();
		foreach (json_decode($requestQuestions->getContent(), true) as $one)
			array_push($questions, new Question($one));
		$questionnaires = array();
		foreach (json_decode($requestQuestionnaires->getContent(), true) as $one)
			array_push($questionnaires, new QuestionnaireEntity($one));
		$form = new AssignQuestionsToQuestionnaire($questions, $questionnaires);
		$viewModel->setVariable('assignForm', $form);
		return $viewModel;
	}
	
    public function createAction()
    {
    	$form = new Questionnaire();
    	$viewModel = new ViewModel(array('form' => $form));
        $request = $this->getRequest();
        if ($request->isPost()) {
        	$form->setData($request->getPost());
       		if ($form->isValid()) {
       			$result = $this->getServiceLocator()->get('k12-api')->sendRequest('/api/questionnaire/create', array('questionnaire' => json_encode($form->getData()->toArray())));
       			$viewModel->setVariable('success', json_decode($result->getContent())->success);
       		}
       		else {
       			print_r($form->getMessages());
       		}
        }
        return $viewModel;
    }
    
    public function assignQuestionsAction()
    {
    	$requestQuestions = $this->getServiceLocator()->get('k12-api')->sendRequest('/api/question/list');
    	$requestQuestionnaires = $this->getServiceLocator()->get('k12-api')->sendRequest('/api/questionnaire/list');
    	$questions = array();
    	foreach (json_decode($requestQuestions->getContent(), true) as $one)
    		array_push($questions, new Question($one));
    	$questionnaires = array();
    	foreach (json_decode($requestQuestionnaires->getContent(), true) as $one)
    		array_push($questionnaires, new QuestionnaireEntity($one));
    	$form = new AssignQuestionsToQuestionnaire($questions, $questionnaires);
    	$viewModel = new ViewModel(array('form' => $form));
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$form->setData($request->getPost());
    		if ($form->isValid()) {
    			$data = $form->getData();
    			$requestParams = array(
    					'questionnaire' => json_encode($data['questionnaire']),
    					'questions' => json_encode($data['questions'])
    			);
    			$result = $this->getServiceLocator()->get('k12-api')->sendRequest('/api/questionnaire/assignQuestions', $requestParams);
    			$viewModel->setVariable('success', json_decode($result->getContent())->success);
    		}
    	}
    	
    	return $viewModel;
    }
}