# zend-psr-log

## Overview

A number of PHP libraries accept a `Psr\Log\LoggerInterface` for logging messages. Unfortunately, applications using
[Zend Framework 2](https://github.com/zendframework/zf2) cannot provide their existing `Zend\Log\Logger` loggers, as
they don't comply with [PSR-3](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md).

In fact, the two interfaces are not compatible, as they declare some common methods with different
signatures. For example:
[Zend alert](https://github.com/zendframework/zf2/blob/master/library/Zend/Log/LoggerInterface.php#L28) vs.
[Psr alert](https://github.com/php-fig/log/blob/master/Psr/Log/LoggerInterface.php#L41).

This library serves as a backwards-compatible replacement for `Zend\Log\Logger` instances that provides a
[Psr\Log](https://github.com/php-fig/log)-compliant interface to the underlying `Zend\Log\Logger` instance. The
result is that you can provide either logger depending on the interface required by a given context, while still
having all messages go through `Zend\Log\Logger` and benefiting from its robustness.

## Installation

The only supported method of installation is [Composer](https://getcomposer.org/).

`composer require "michaelmoussa/zend-psr-log"`

## Configuration

To begin, you must add the `ZendPsrLog` module to your `application.config.php` module list as with any ZF2 application.

```php
return [
    'modules' => [
        ...,

        'ZendPsrLog',

        ...
    ],
    ...
];
```

Further configuration depends on how you are presently getting your instances of a `Zend\Log\Logger`.

### "I define a `log` key in my configuration and let `Zend\Log\LoggerAbstractServiceFactory` do the work."

Then you're done! `ZendPsrLog` adds its own factory for creating `Zend\Log\Logger` instances, which will be invoked
before the Abstract Factory.

### "I define a `log` key in my configuration and have my own `'Zend\Log\Logger' => '...'` factory definition in the
service manager config."

You need to remove it, as your definition will override the one done by the `ZendPsrLog\LoggerFactory`.

### "I use `new \Zend\Log\Logger(...)`."

1. Please don't. :) You should be using the `ServiceManager`.
2. Replace `new \Zend\Log\Logger` with `new \ZendPsrLog\Logger`.

## Usage

### As a `Zend\Log\LoggerInterface`

The `ZendPsrLog\Logger` is an extension of `Zend\Log\Logger`, so any class you have in your application that is
presently using a `Zend\Log\Logger` can use the `ZendPsrLog\Logger` without any additional configuration.

### As a `Psr\Log\LoggerInterface`

Suppose you have a class that requires a `Psr\Log\LoggerInterface` instance:

```php
use Psr\Log\LoggerInterface;

class Foo
{
    public function __construct(LoggerInterface $logger) { ... }
}
```

And you obtain an instance of the `ZendPsrLog\Logger`:

```php
/** @var \ZendPsrLog\Logger $logger */
$logger = $serviceManager->get('Zend\Log\Logger');
```

Just use the `->getPsrLogger()` method to obtain a `Psr\Log\LoggerInterface` to your existing `Zend\Log\Logger`:

```php
$foo = new Foo($logger->getPsrLogger());
```
