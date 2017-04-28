<?php

namespace K12\Controller;

use K12\Form\Login;
use K12\Model\User;
use K12\Model\UserMapper;
use K12\Service\AuthenticationAdapter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class AuthController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel(array('user' => $this->getServiceLocator()->get('AuthenticationService')->getIdentity()));
    }
    
    public function loginAction()
    {
        $loginForm = new Login();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $loginForm->setData($request->getPost());
            if ($loginForm->isValid()) {
                $serviceLocator = $this->getServiceLocator();
                $authService = $serviceLocator->get('AuthenticationService');
                $validatedData = $loginForm->getData();
                $result = $authService->authenticate(new AuthenticationAdapter(
                    $serviceLocator->get('k12-api'),
                    $validatedData['identity'],
                    $validatedData['password']
                ));
                if ($result->isValid())
                    return $this->redirect()->toRoute('home');
            }
        }
        $this->layout('layout/login');
        return new ViewModel(array('loginForm' => $loginForm));
    }
    
    public function logoutAction()
    {
        $authService = $this->getServiceLocator()->get('AuthenticationService');
        $authService->clearIdentity();
        return $this->redirect()->toRoute('authentication/login');
    }
}

?>