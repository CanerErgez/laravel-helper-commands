![Laravel Helper Commands](https://banners.beyondco.de/Laravel%20Helper%20Commands.png?theme=light&packageManager=composer+require&packageName=caner%2Flaravel-helper-commands&pattern=architect&style=style_2&description=&md=1&showWatermark=0&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg)

# Laravel Helper Commands

[![Latest Version on Packagist](https://img.shields.io/packagist/v/caner/laravel-helper-commands.svg?style=flat-square)](https://packagist.org/packages/caner/laravel-helper-commands)  
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/CanerErgez/laravel-helper-commands/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/CanerErgez/laravel-helper-commands/actions?query=workflow%3Arun-tests+branch%3Amain)  
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/CanerErgez/laravel-helper-commands/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/CanerErgez/laravel-helper-commands/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)  
[![Total Downloads](https://img.shields.io/packagist/dt/caner/laravel-helper-commands.svg?style=flat-square)](https://packagist.org/packages/caner/laravel-helper-commands)
---  

## Installation

You can install the package via composer:

```bash  
composer require caner/laravel-helper-commands
```  

You can publish the config file with:

```bash  
php artisan vendor:publish --tag="laravel-helper-commands-config"
```  

This is the contents of the published config file:

```php  
<?php

/**
 * Caner/LaravelHelperCommands Config File.
 */
return [
    /**
     * List all controllers paths.
     *
     * This value is used to find all Controller files.
     */
    'controller_paths' => [
        'App/Http/Controllers',
    ],

    /**
     * List Excluded controllers for permission check.
     */
    'excluded_controllers_for_permission_check' => [
        // 'App\Http\Controllers\TestController'
    ],
];
```  

## Usage

This command list not authorized controller methods. Please see [Laravel Authorization Via Controller Helpers](https://laravel.com/docs/9.x/authorization#via-controller-helpers) ;
```bash 
php artisan dev:permission-check
```  

This command will list the methods that are in the route but not in the controller;
```bash 
php artisan dev:missing-routes
```  

This command will list the methods that are in the controller but not in the route;
```bash 
php artisan dev:missing-controller-methods
```  

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.


## Credits

- [Caner Ergez](https://github.com/CanerErgez)
- [Emre Deligöz](https://github.com/deligoez)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.