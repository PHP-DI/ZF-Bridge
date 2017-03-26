<?php
/**
 * PHP-DI
 *
 * @link http://mnapoli.github.io/PHP-DI/
 * @copyright Matthieu Napoli (http://mnapoli.fr/)
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */
namespace DI\ZendFramework;

// compatibility with zend > 2.5
$controllerType = 'ControllerLoader';
if (class_exists('\Zend\Version\Version')) {
    $version = new \Zend\Version\Version();
    if ($version::compareVersion('2.5.0') <= 0) {
        $controllerType = 'ControllerManager';
    }
}

return [
    'controllers' => [
        'invokables' => [
            'DI\\ZendFramework\\Controller\\Console' => 'DI\\ZendFramework\\Controller\\ConsoleController',
        ],
    ],

    'service_manager' => [
        'abstract_factories' => array(
            __NAMESPACE__ . '\\Service\\PHPDIAbstractFactory' => __NAMESPACE__ . '\\Service\\PHPDIAbstractFactory',
        ),

        'factories' => [
            $controllerType => __NAMESPACE__ . '\\Service\\ControllerLoaderFactory',
            'DiCache' => __NAMESPACE__ . '\\Service\\CacheFactory',
        ],
    ],

    'console' => [
        'router' => [
            'routes' => [
                'php-di-clear-cache' => [
                    'options' => [
                        'route'    => 'php-di-clear-cache',
                        'defaults' => [
                            'controller' => __NAMESPACE__ . '\Controller\Console',
                            'action'     => 'clearCache',
                            '__NAMESPACE__' => __NAMESPACE__,
                        ]
                    ]
                ],
            ]
        ],
    ],

    'phpdi-zf' => [
        'useAnntotations' => false,
    ],
];
