# PHP-DI integration with Zend Framework 3

[![Build Status](https://travis-ci.org/PHP-DI/ZF3-Bridge.svg)](https://travis-ci.org/PHP-DI/ZF3-Bridge)

This library provides integration for PHP-DI with Zend Framework 3.

[PHP-DI](http://php-di.org/) is a Dependency Injection Container for PHP.

If you are looking for Zend Framework 1 integration, head over [here](https://github.com/php-di/PHP-DI-ZF1).
If you are looking for Zend Framework 2 integration, head over [here](https://github.com/php-di/PHP-DI-ZF2).

## Use

Require the libraries with Composer:

```json
{
    "require": {
        "php-di/php-di": "*",
        "php-di/zf3-bridge": "*"
    }
}
```

To use PHP-DI in your ZF3 application, you need to edit `application_root/config/application.config.php`:

```php
    // ...
    'modules' => [
        'DI\ZendFramework3',
        'Zend\Router',
        'Zend\Mvc\Console',
        ...
    ],

    'service_manager' => [
        // ...
        'factories' => [
            'DI\Container' => DI\ZendFramewor3\Service\DIContainerFactory::class,
        ],
    ],
```

That's it!

Now you dependencies are injected in your controllers!

If you'd like to specify the di configuration yourself, create this file: `application_root/config/php-di.config.php`
and save it with your PHP DI configuration e.g. like this:

```
return [
    'Application\Service\GreetingServiceInterface' => Di\object('Application\Service\GreetingService'),
];
```

Head over to [PHP-DI's documentation](http://php-di.org/doc/) if needed.

## Fine tuning

To configure the module, you have to override the module config somewhere at config/autoload/global.php
or config/autoload/local.php.

```php
return [
    'phpdi-zf3' => [
        ...
    ]
];
```

### Override definitions file location

```php
return [
    'phpdi-zf3' => [
        'definitionsFile' => realpath(__DIR__ . '/../my.custom.def.config.php'),
    ]
];
```

### Enable or disable annotations

```php
return [
    'phpdi-zf3' => [
        'useAnntotations' => true,
    ]
];
```

### Enable file cache

```php
return [
    'phpdi-zf3' => [
        'cache' => [
            'adapter' => 'filesystem',
            'namespace' => 'your_di_cache_key',
            'directory' => 'your_cache_directory', // default value is data/php-di/cache
        ],
    ]
];
```

### Enable redis cache

If you are also using Redis for storing php sessions, it is very useful to configure the php-di
cache handler to use a different database, since you might accidentally delete all your sessions
when clearing the php-di definitions cache.

```php
return [
    'phpdi-zf3' => [
        'cache' => [
            'namespace' => 'your_di_cache_key',
            'adapter' => 'redis',
            'host' => 'localhost', // default is localhost
            'port' => 6379, // default is 6379
            'database' => 1, // default is the same as phpredis default
        ],
    ]
];
```

### Enable Memcached cache

If you're using Memcached, you should have only one project per memcached instance.

```php
return [
    'phpdi-zf3' => [
        'cache' => [
            'adapter' => 'memcached',
            'host' => 'localhost', // default is localhost
            'port' => 11211, // default is 11211
        ],
    ]
];
```

## Console commands

### Clear definition cache

To clear the definition cache, run the following command from the project root:

```
php public/index.php php-di-clear-cache
```

## Run sample application

Run `composer install --dev`

After that, open terminal and go to the `quickstart` folder and run `php -S 0.0.0.0:8080 -t public public/index.php`

Open a browser and go to this address: `http://localhost:8080/hello`

You should see a page with a greeting coming from the GreetingController, which is being resolved by the PHP-DI configuration.
