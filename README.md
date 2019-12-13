# Aprendendo Consumir API Webservice SOAP
## Lumen - Laravel

## Testes.

## Installation

- https://www.php.net/manual/pt_BR/book.soap.php
- https://framework.zend.com/manual/2.0/en/modules/zend.soap.server.html
- // Simple Object Access Protocol - SOAP
- // Web Services Description Language - WSDL
- // Chamada remota de procedimento - RPC
```
$ composer require zendframework/zend-soap
$ composer require artisaninweb/laravel-soap
$ composer require nesbot/carbon
$ composer require nb/oxymel
```
- Install

```sh
	sudo apt-get install libxml php7.2-soap
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
  "guzzlehttp/guzzle": "^6.3",
  "kylekatarnls/laravel-carbon-2": "^1.0.0",
  "nesbot/carbon": "2.0.0"


- https://portal.tcu.gov.br/webservices-tcu/principal.htm
- https://portal.tcu.gov.br/webservices-tcu/
- https://github.com/briannesbitt/Carbon
- Renato de Oliveira Lucena - 04/12/2019

Esse código foi utilizado para a criação do curso [Webservices com PHP](https://www.schoolofnet.com/curso/php/linguagem-php/webservices-com-php/) da School of Net.

A School of Net é uma escola online que ensina as mais diversas tecnologias no mundo da programação, desenvolvimento web, games, design e infraestrutura.

School of Net - [https://www.schoolofnet.com](https://www.schoolofnet.com)

Blog da School of Net - [https://blog.schoolofnet.com](https://blog.schoolofnet.com)

SONCast - Podcast da School of Net - [https://podcast.schoolofnet.com](https://podcast.schoolofnet.com)

Canal da School of Net no Youtube: [http://www.youtube.com/c/SchoolofNetCursos](http://www.youtube.com/c/SchoolofNetCursos)

oxymel – a sweet XML builder [![Build Status](https://travis-ci.org/nb/oxymel.png)](https://travis-ci.org/nb/oxymel)
============================

```php
$oxymel = new Oxymel;
echo $oxymel
  ->xml
  ->html->contains
    ->head->contains
      ->meta(array('charset' => 'utf-8'))
      ->title("How to seduce dragons")
    ->end
    ->body(array('class' => 'story'))->contains
      ->h1('How to seduce dragons', array('id' => 'begin'))
      ->h2('The fire manual')
      ->p('Once upon a time in a distant land there was an dragon.')
      ->p('In another very distant land')->contains
        ->text(' there was a very ')->strong('strong')->text(' warrrior')
      ->end
      ->p->contains->cdata('<b>who fought bold dragons</b>')->end
      ->raw('<p>with not fake <b>bold</b> dragons, too</p>')
      ->tag('dragon:identity', array('name' => 'Jake'))
      ->comment('no dragons were harmed during the generation of this XML document')
    ->end
  ->end
  ->to_string();
```

Outputs:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>How to seduce dragons</title>
  </head>
  <body class="story">
    <h1 id="begin">How to seduce dragons</h1>
    <h2>The fire manual</h2>
    <p>Once upon a time in a distant land there was an dragon.</p>
    <p>In another very distant land there was a very <strong>strong</strong> warrrior</p>
    <p><![CDATA[<b>who fought bold dragons</b>]]></p>
    <p>with not fake <b>bold</b> dragons, too</p>
    <dragon:identity name="Jake"/>
    <!--no dragons were harmed during the generation of this XML document-->
  </body>
</html>
```


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


### Aluno
- Renato Lucena 12/2019