# Laravel Trustpilot PHP API

## Installation

You can install the package via composer:

```bash
composer require mccaulay/laravel-trustpilot
```

## Official Documentation
- [Trustpilot Documentation](https://developers.trustpilot.com/)

## Environment Variables
```
TRUSTPILOT_UNIT_ID=
TRUSTPILOT_ACCESS_TOKEN=
```

## Usage
### Business Unit
- Get the first business unit
```php
        $businessUnit = Trustpilot::businessUnits()->first();
```

- Get the 2nd page of business units with 5 per page.
```php
        $businessUnits = Trustpilot::businessUnits()->limit(5)->page(2)->get();
```

- Search for the first business unit with the name 'Trustpilot'
```php
        $businessUnit = Trustpilot::businessUnits()->search('Trustpilot')->first();
```

- Get the first business unit's first review
```php
        $review = Trustpilot::businessUnits()->first()->reviews()->first();
```

- Get the logo of the searched business.
```php
        $logo = Trustpilot::businessUnits()->search('Trustpilot')->first()->logo();
```

- Get three of your business reviews ordered by lowest star to highest.
```php
        $reviews = Trustpilot::businessUnit()->reviews()->orderBy('stars', 'asc')->limit(3)->get();
```

- Get one of your business reviews which is one star and has a response.
```php
        $review = Trustpilot::businessUnit()->reviews()->where('stars', 1)->where('responded', true)->first();
```

- Get the review title of 5 of your reviews offseted by 5.
```php
        $reviews = Trustpilot::businessUnit()->reviews()->limit(5)->offset(5)->get()->pluck('title');
```

- Get the web links of your business.
```php
        $webLinks = Trustpilot::businessUnit()->webLinks();
```

- Get the logo of your business.
```php
        $logo = Trustpilot::businessUnit()->logo();
```

- Get the customer guarantee of your business.
```php
        $customerGuarantee = Trustpilot::businessUnit()->customerGuarantee();
```

- Get the images of your business.
```php
        $images = Trustpilot::businessUnit()->images();
```

- Get the profile of your business.
```php
        $profile = Trustpilot::businessUnit()->profile();
```

- Get the promotion of your business.
```php
        $promotion = Trustpilot::businessUnit()->promotion();
```

## Credits

- [McCaulay Hudson](https://github.com/mccaulay)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
