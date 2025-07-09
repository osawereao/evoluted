# Evoluted

Evoluted is a PHP CLI tool for parsing card game data and computing scores, developed by [Anthony Osawere](https://osawere.com).

## Features

- Parses input files describing card games
- Calculates cumulative points based on matching cards
- Provides CLI scripts for data processing
- Fully unit tested with Pest PHP testing framework

## Requirements

- PHP 8.4.10 or higher
- Composer
- `input.txt` file containing card data (located in `storage/` directory)



## Installation

Clone the repository, install dependencies and run unit test:

- git clone https://github.com/osawereao/evoluted.git
- run `composer install`
- run `composer test`  *(for PEST Unit Testing)*

## Usage

- Place your card data file as input.txt inside the storage/ directory.
- From the root directory with your CLI tool:
  - run `php bin/reader.php` *(for script 1)* OR
  - run `php bin/point.php` *(for script 2)*
