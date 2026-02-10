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

The unit tests are based on PHPUnit and can be executed via Docker:

```bash
docker run --rm -it \
  -v "$(pwd):/app" \
  -w /app \
  composer ./vendor/bin/phpunit
```

This command uses the `phpunit.xml.dist` configuration file located at the root of the project.
