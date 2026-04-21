# HtmlTemplate

[![Packagist Version](https://img.shields.io/packagist/v/lvinceslas/htmltemplate.svg)](https://packagist.org/packages/lvinceslas/htmltemplate)
[![PHP Version](https://img.shields.io/packagist/php-v/lvinceslas/htmltemplate.svg)](https://packagist.org/packages/lvinceslas/htmltemplate)
[![License](https://img.shields.io/packagist/l/lvinceslas/htmltemplate.svg)](LICENSE)

A simple template engine for PHP.

## Installation

```bash
composer require lvinceslas/htmltemplate
```

### Using Docker (without Composer installed locally)

```bash
docker run --rm -it \
  -v "$(pwd):/app" \
  -w /app \
  composer require lvinceslas/htmltemplate
```

## Usage

Create an HTML template file with placeholders, for example:

```html
Hello <b>{%NAME%}</b>, you have successfully installed <em>lvinceslas/htmltemplate</em>!
```

Then use it in PHP:

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Lvinceslas\Html\HtmlTemplate;

$template = new HtmlTemplate(__DIR__ . '/path/to/template.html');
$template->set('NAME', 'John Doe');

// You can echo the object directly
echo $template;

// Or explicitly call show()
// $template->show();
```

## Running the test suite

Unit tests use [PHPUnit](https://phpunit.de/) 9.6 (dev dependency). From a clone of this repository, install dependencies then run the suite:

```bash
composer install
./vendor/bin/phpunit
```

Configuration is read from `phpunit.xml.dist` at the project root.

### Using Docker (without Composer installed locally)

```bash
docker run --rm -it \
  -v "$(pwd):/app" \
  -w /app \
  composer:latest \
  sh -c "composer install --no-interaction && ./vendor/bin/phpunit"
```
