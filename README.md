# Hearth

A simple starter kit for the Laravel framework.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/greatislander/hearth.svg?style=flat-square)](https://packagist.org/packages/greatislander/hearth)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/greatislander/hearth/run-tests?label=tests)](https://github.com/greatislander/hearth/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/greatislander/hearth/Check%20&%20fix%20styling?label=code%20style)](https://github.com/greatislander/hearth/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/greatislander/hearth.svg?style=flat-square)](https://packagist.org/packages/greatislander/hearth)

---

Hearth is a simple starter kit for the Laravel framework. It provides a few things out of the box:

- [ ] A user model with login, registration, email verification, and optional two-factor authentication.
- [ ] An organization model.
- [ ] A membership model which reflects users' roles within organizations.
- [ ] An invitation model which allows users to be invited to join organizations.
- [ ] Multilingual support, including localized routes.
- [ ] Bare bones views which can be published and customized as needed.

## Installation

You can install the package via composer:

```bash
composer require greatislander/hearth
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Hearth\HearthServiceProvider" --tag="hearth-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Hearth\HearthServiceProvider" --tag="hearth-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

TODO.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [OCAD University](https://github.com/fluid-project)
- [All Contributors](../../contributors)

## License

The BSD 3-Clause License. Please see [License File](LICENSE.md) for more information.
