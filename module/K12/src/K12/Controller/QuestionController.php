<?php

namespace K12\Controller;

use Application\Entity\Question;
use Application\Mapper\QuestionMapper;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class QuestionController extends AbstractActionController
{
    public function indexAction()
    {
        $message = $this->params()->fromRoute('message');
        $apiRequest = $this->getServiceLocator()->get('k12-api')->sendRequest('/api/question/list');
        $resultSet = new ResultSet();
        $content = json_decode($apiRequest->getContent());
        if (!$content || !is_array($content))
        	$resultSet->initialize(array());
        else
        	$resultSet->initialize($content);
        return new ViewModel(array('questions' => $resultSet, 'message' => $message));
    }
    
    public function createAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $result = $this->getServiceLocator()->get('k12-api')->sendRequest('/api/question/create', array('question' => json_encode($request->getPost()->toArray())));
            if (json_decode($result->getContent())->success)
                return $this->redirect()->toRoute('question', array('message' => 'createSuccess'));
            else
                return $this->redirect()->toRoute('question', array('message' => 'createFailed'));
        }
    }
    
    public function deleteAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($this->params()->fromPost('confirm') == 'y') {
                $result = $this->getServiceLocator()->get('k12-api')->sendRequest('/api/question/delete', array('id' => $this->params()->fromPost('id')));
                if (json_decode($result->getContent())->result)
                    return $this->redirect()->toRoute('question', array('message' => 'deleteSuccess'));
                else
                    return $this->redirect()->toRoute('question', array('message' => 'deleteFailed'));
            }
        }
        if (!$this->params()->fromRoute('param'))
            return $this->redirect()->toRoute('question', array('message' => 'noIdProvided'));
        return new ViewModel(array('id' => $this->params()->fromRoute('param')));
    }
    
    public function listAction()
    {
        
    }
}
