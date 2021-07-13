# Hearth

A simple starter kit for the Laravel framework.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/fluid-project/hearth.svg)](https://packagist.org/packages/fluid-project/hearth)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/fluid-project/hearth/run-tests?label=tests)](https://github.com/fluid-project/hearth/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/fluid-project/hearth/Check%20&%20fix%20styling?label=code%20style)](https://github.com/fluid-project/hearth/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/fluid-project/hearth.svg)](https://packagist.org/packages/fluid-project/hearth)

---

Hearth is a simple starter kit for the Laravel framework. It provides a few things out of the box:

- [ ] A user model with login, registration, email verification, and optional two-factor authentication.
- [ ] An organization model.
- [ ] A membership model which reflects users' roles within organizations.
- [ ] An invitation model which allows users to be invited to join organizations.
- [ ] A resource model supporting creation of and access to a library of open educational resources in a wide range of formats.
- [ ] Multilingual support, including localized routes.
- [ ] Bare bones views which can be published and customized as needed.

## Installation

You may use Composer to install Hearth into your new Laravel project:

```bash
composer require fluid-project/hearth
```

_Note: attempting to install Hearth into an existing Laravel application will result in unexpected behaviour._

After installing the Hearth package, you can use the `hearth:install` Artisan command to
install the Hearth scaffolding within your Laravel application:

```bash
php artisan hearth:install
```

After installing Hearth, you will need to install and build your NPM dependencies
and run your database migrations:

```bash
npm install
npm run dev
php artisan migrate
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
