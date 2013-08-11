<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'about' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/about',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'about',
                    ),
                ),
            ),
            'doc' => array(
                'type' => 'Zend\Mvc\Router\Http\Regex',
                'options' => array(
                    'regex'    => '/doc(?<page>\/[a-zA-Z0-9_\-]+)\.html',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'doc',
                    ),
                    'spec'=>'/doc/%page%.html'
                ),
            ),
            'static' => array(
                'type' => '\Application\Service\StaticRoute',
                'options' => array(
                    'dir_name'         => __DIR__ . '/../view',
                    'template_prefix'  => 'application/index/static',
                    'filename_pattern' => '/[a-z0-9_\-]+/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'static',
                    ),                    
                ),
            ),
            'barcode' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/barcode[/:type/:label]',
                    'constraints' => array(
                        'type' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'label' => '[a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'barcode',
                    ),
                ),
            ),
            'blog' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/blog',
                    'defaults' => array(                        
                    ),
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'wildcard' => array(
                        'type' => 'Zend\Mvc\Router\Http\Wildcard',
                        'options' => array(                    
                            'key_value_delimiter' => '/',
                            'param_delimiter' => '/',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Index',
                                'action'     => 'blog',
                            ),
                        ),
                    ),
                ),
            ),            
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
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
                                'type'       => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'label'      => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),    
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController'
        ),
    ),
    
    // The following registers our custom view helper classes in view plugin manager.
    'view_helpers' => array(
       'invokables' => array(
          'mainMenu' => 'Application\View\Helper\Menu',          
          'pageBreadcrumbs' => 'Application\View\Helper\Breadcrumbs',          
       ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
