# Currency exchange rate for Laravel

This package provides an endpoint to get the rate for the given amount and currency.

- [Installation](#installation)
- [Usage](#usage)
- [Publishing the config file](#publishing-the-config-file)
- [License](#license)

## Installation

Require this package with composer using the following command:

```bash
composer require automaticko/currency-exchange-rate
```

## Usage

The package exposes a new endpoint "/currency-exchange-rate/rate"
that provides the functionality.

The prefix can be changed from a config.


## Publishing the config file

You can publish the config running the following command
`php artisan vendor:publish --tag="currency-exchange-rate-config"`

The config will be copied to the app config directory as `currency-exchange-rate.php`
You can modify the prefix there.


## License

The Currency Exchange Rate is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
