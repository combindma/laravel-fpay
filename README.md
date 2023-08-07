# Laravel package integration to Fpay payment plateform

[![Latest Version on Packagist](https://img.shields.io/packagist/v/combindma/laravel-fpay.svg?style=flat-square)](https://packagist.org/packages/combindma/laravel-fpay)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/combindma/laravel-fpay/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/combindma/laravel-fpay/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/combindma/laravel-fpay/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/combindma/laravel-fpay/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/combindma/laravel-fpay.svg?style=flat-square)](https://packagist.org/packages/combindma/laravel-fpay)


## About Combind Agency

[Combine Agency](https://combind.ma?utm_source=github&utm_medium=banner&utm_campaign=package_name) is a leading web development agency specializing in building innovative and high-performance web applications using modern technologies. Our experienced team of developers, designers, and project managers is dedicated to providing top-notch services tailored to the unique needs of our clients.

If you need assistance with your next project or would like to discuss a custom solution, please feel free to [contact us](mailto:hello@combind.ma) or visit our [website](https://combind.ma?utm_source=github&utm_medium=banner&utm_campaign=package_name) for more information about our services. Let's build something amazing together!


## Installation

Vous pouvez installer le package via composer :

```bash
composer require combindma/laravel-fpay
```

En option, vous pouvez publier le fichier de configuration avec :

```bash
php artisan vendor:publish --tag="laravel-fpay-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionnellement, vous pouvez publier les vues en utilisant :

```bash
php artisan vendor:publish --tag="laravel-fpay-views"
```

## Configuration

Vous devez fournir toutes les informations d'identification requises dans votre fichier .env :

```php
FPAY_MERCHANT_ID= //Identifiant du marchand (attribué par FPAY)
FPAY_MERCHANT_KEY= //clé secrète du magasin (configurée dans votre espace back office de la plate-forme FPAY)
FPAY_BASE_URI= //Gateway de paiement en mode web (attribué par le FPAY). Exemple de test: https://payment.fpay-worldwide.com/sandbox/fpay-frontend/fpayreq
FPAY_MERCHANT_URL= //L'URL de retour vers laquelle le client est redirigé lorsqu'il clique sur le bouton "Annuler" affiché sur la page de paiement.
FPAY_URLREPAUTO= //L’URL utilisée dans la requête de confirmation de paiement en mode server to server
```

Voir ci-dessous comment configurer les okUrl, failUrl, shopUrl et callbackUrl.

## Utilisation

En cours de préparation

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Combind](https://github.com/combindma)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
