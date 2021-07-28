# Hearth

A simple starter kit for the Laravel framework.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/fluid-project/hearth.svg)](https://packagist.org/packages/fluid-project/hearth)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/fluid-project/hearth/run-tests?label=tests)](https://github.com/fluid-project/hearth/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/fluid-project/hearth/Check%20&%20fix%20styling?label=code%20style)](https://github.com/fluid-project/hearth/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Code coverage status](https://img.shields.io/codecov/c/github/fluid-project/hearth?flag=flag_name&token=jyzyzAaPSx)](https://app.codecov.io/gh/fluid-project/hearth/)
[![Localization status](https://badges.crowdin.net/laravel-hearth/localized.svg)](https://crowdin.com/project/laravel-hearth)
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

After installing Hearth, you will need to install and build your NPM dependencies, run your database migrations and link
public storage:

```bash
npm install
npm run dev
php artisan migrate
php artisan storage:link
```

### Emails

In order to test emails (for example, using Mailhog with [Laravel Sail](https://laravel.com/docs/8.x/sail#previewing-emails)),
you must update your Laravel application's `.env` file's `MAIL_FROM_ADDRESS` environment variable with a
properly-formatted email address. For local development, this might be `noreply@hearth.test` (assuming your local
 application is accessible at `http://hearth.test`).

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

## Third Party Software in Hearth

Hearth is based on other publicly available software, categorized by license:

### MIT License

- [Laravel Breeze](https://github.com/laravel/breeze)
- [Laravel Jetstream](https://github.com/laravel/jetstream)
- [Laravel Package Skeleton](https://github.com/spatie/package-skeleton-laravel)
