# Evoluted

Evoluted is a PHP CLI tool for parsing card game data and computing scores in the Evoluted technical test as developed by [Anthony Osawere](https://osawere.com).

## Testing

The unit tests is written using PEST.

### Requirements

- PHP 8.4.10 or higher
- Composer
- PHP Pest
- Input.txt (file containing card data)

### Setup Instructions

Clone the repository or download the zip file:
The setup is similar to the following directory structure:

.
├── .gitignore
├── composer.json
├── init.php
├── phpunit.xml
├── README.md
├── bin/
│   └── point.php
│   └── reader.php
├── evoluted/
│   └── Helper/
│      └── File.php
│      └── Json.php
│      └── Publish.php
│   └── Evoluted.php
└── storage/
│   └── input.txt
└── tests/
│   └── Helper/
│      └── Publish.php
│   └── EvolutedTest.php
└── Pest.php

### Install Composer:

Navigate to the root directory of the project in your terminal and run:

`composer install && composer test`

This command will...

* Download PHPUnit and PEST, and all its dependencies
* Set up the autoloader
* And run Unit Test (6)
