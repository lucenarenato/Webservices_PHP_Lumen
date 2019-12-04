
## Installation

- https://www.php.net/manual/pt_BR/book.soap.php
- https://framework.zend.com/manual/2.0/en/modules/zend.soap.server.html
- // Simple Object Access Protocol - SOAP
- // Web Services Description Language - WSDL
- // Chamada remota de procedimento - RPC
```
$ composer require zendframework/zend-soap
```
- Install

```sh
    sudo apt-get install php7.2-soap
    sudo apt-get install php7.2-intl
    grep -r "soap.dll" /etc/php/7.2/cli/
    php -i | grep -i soap
```
resposta:
```sh
	/etc/php/7.2/cli/conf.d/20-soap.ini,
	soap
	Soap Client => enabled
	Soap Server => enabled
	soap.wsdl_cache => 1 => 1
	soap.wsdl_cache_dir => /tmp => /tmp
	soap.wsdl_cache_enabled => 1 => 1
	soap.wsdl_cache_limit => 5 => 5
	soap.wsdl_cache_ttl => 86400 => 86400

```
- https://portal.tcu.gov.br/webservices-tcu/principal.htm
- https://portal.tcu.gov.br/webservices-tcu/
- Renato de Oliveira Lucena - 04/12/2019

Esse código foi utilizado para a criação do curso [Webservices com PHP](https://www.schoolofnet.com/curso/php/linguagem-php/webservices-com-php/) da School of Net.

A School of Net é uma escola online que ensina as mais diversas tecnologias no mundo da programação, desenvolvimento web, games, design e infraestrutura.

School of Net - [https://www.schoolofnet.com](https://www.schoolofnet.com)

Blog da School of Net - [https://blog.schoolofnet.com](https://blog.schoolofnet.com)

SONCast - Podcast da School of Net - [https://podcast.schoolofnet.com](https://podcast.schoolofnet.com)

Canal da School of Net no Youtube: [http://www.youtube.com/c/SchoolofNetCursos](http://www.youtube.com/c/SchoolofNetCursos)

## Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](http://lumen.laravel.com/docs).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

### License

The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
