<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace K12;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $sm  = $e->getApplication()->getServiceManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $eventManager->attach(MvcEvent::EVENT_ROUTE, function(MvcEvent $e) use ($sm) {
            $routeMatch = $e->getRouteMatch();
            $controllerName = $routeMatch->getParams()['controller'];
            $actionName = $routeMatch->getParams()['action'];
            $moduleName = substr($controllerName,0,strpos($controllerName,'\\'));
            if ($moduleName == 'K12' && !$sm->get('AuthenticationService')->hasIdentity() && $actionName != 'login'/*!$sm->get('zfcuser_auth_service')->hasIdentity()*/) {
                $url = $e->getRouter()->assemble(array(), array('name' => 'authentication/login'));
                $response=$e->getResponse();
                $response->getHeaders()->addHeaderLine('Location', $url);
                $response->setStatusCode(302);
                $response->sendHeaders();
                
                $stopCallBack = function($event) use ($response) {
                    $event->stopPropagation();
                    return $response;
                };

                $e->getApplication()->getEventManager()->attach(MvcEvent::EVENT_ROUTE, $stopCallBack,-10000);
                return $response;
            }
        });

        
        
        /*$eventManager->attach(MvcEvent::EVENT_ROUTE, function(MvcEvent $e) {
            $routeMatch = $e->getRouteMatch();
            // do your check for a namespace/controller
            if($routeMatch->getMatchedRouteName() == 'authentication/login') {
                $e->getViewModel()->setTemplate('layout/login');
            }
        });*/
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getViewHelperConfig()
	{
		return array(
			'factories' => array(
				'UserMenu' => function ($sm) {
				    $authService = $sm->getServiceLocator()->get('AuthenticationService');
					return new View\Helper\UserMenu($authService->getIdentity());
				},
				'UserIdentity' => function ($sm) {
					$authService = $sm->getServiceLocator()->get('AuthenticationService');
					return new View\Helper\UserIdentity($authService->getIdentity());
				}
			)
		);
	}

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    'Sorus' => __DIR__ . '/../../vendor/Sorus/lib',
                ),
            ),
        );
    }
}
