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

composer require "michaelmoussa/zend-psr-log"
