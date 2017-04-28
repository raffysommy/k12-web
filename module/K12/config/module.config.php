<?php

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'K12\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'question' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/question[/:action[/:param][/:message]]',
                    'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'param'     => '[a-zA-Z0-9_-]*',
                                'message'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                    'defaults' => array(
                        'controller' => 'K12\Controller\Question',
                        'action'     => 'index',
                    ),
                ),
            ),
            'questionnaire' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/questionnaire[/:action]',
                    'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'param'     => '[a-zA-Z0-9_-]*',
                                'message'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                    'defaults' => array(
                        'controller' => 'K12\Controller\Questionnaire',
                        'action'     => 'index',
                    ),
                ),
            ),
            'test' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/K12',
                    'defaults' => array(
                        '__NAMESPACE__' => 'K12\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            'authentication' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/auth',
                    'defaults' => array(
                        '__NAMESPACE__' => 'K12\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/login',
                            'defaults' => array(
                                'controller'    => 'Auth',
                                'action'        => 'login',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/logout',
                            'defaults' => array(
                                'controller'    => 'Auth',
                                'action'        => 'logout',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'K12\Controller\Index' => 'K12\Controller\IndexController',
            'K12\Controller\Question' => 'K12\Controller\QuestionController',
            'K12\Controller\Questionnaire' => 'K12\Controller\QuestionnaireController',
            'K12\Controller\Auth' => 'K12\Controller\AuthController'
        ),
    ),
    'service_manager' => array(
        'factories' => array(
    		'AuthenticationService' => function ($sm) {
    		    return new K12\Service\AuthenticationService($sm->get('k12-api'));
    		},
    		'k12-api' => 'K12\Factory\Service\OAuthServiceManagerFactory' 
        ),
    ),
    'view_manager' => array(
    	'display_not_found_reason' => true,
    	'display_exceptions'       => true,
    	'doctype'                  => 'HTML5',
    	'not_found_template'       => 'error/404',
    	'exception_template'       => 'error/index',
        'template_path_stack' => array(
            __DIR__ . '/../view'
        ),
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'user/login' => __DIR__ . '/../view/layout/login.phtml',
    		'error/404'               => __DIR__ . '/../view/error/404.phtml',
    		'error/index'             => __DIR__ . '/../view/error/index.phtml'
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    )
);
