# Pet Shop

This is a petshop API basic system

- [Installation](#installation)
- [Documentation](#documentation)
- [License](#license)

## Installation

1. Clone project
2. Copy `.env.example` to `.env`
3. Generate an RSA pem key (check [here](https://developers.yubico.com/PIV/Guides/Generating_keys_using_OpenSSL.html)) (TL/DR linux: `openssl genrsa -out key.pem 2048`)
4. Set JWT_PEM_KEY in your .enf file pointing to the generated pem key
5. Set database credentials in your .env file
6. Set APP_URL in your .env file
7. Run `php artisan key:generate`
8. Run `php artisan migrate --seed`
9. Done!

## Documentation

* Navigate to `your-host/documenation` to load the swagger API documentation.
* Navigate to `your-host/docs` to visualize the raw openapi documentation file.

## License

The Currency Exchange Rate is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)



This project is just an example
