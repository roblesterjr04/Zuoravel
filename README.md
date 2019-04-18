# Zuoravel

Easily connect with APIs and integrate Zuora with your Laravel application

## Installation

Install via composer

```bash
composer require rob-lester-jr04/zuoravel
```

### Register Service Provider

**Note! This and next step are optional if you use laravel>=5.5 with package
auto discovery feature.**

Add service provider to `config/app.php` in `providers` section

```php
Lester\Zuoravel\ServiceProvider::class,
```

### Publish Configuration File

**Note that this is optional and in most cases, the configuration here is not needed.

```bash
php artisan vendor:publish --provider="Lester\Zuoravel\ServiceProvider" --tag="config"
```
