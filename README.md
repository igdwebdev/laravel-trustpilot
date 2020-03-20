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

## TO-DO
- Consumer API
- Consumer Profile API
- Invitation API
- Private Products API
- Private Reviews API
- Resources API
- Service Reviews API
- BUsiness Units API (Private Reviews)

## Usage
### Business Unit
```php
// Get the first business unit
$businessUnit = Trustpilot::businessUnits()->first();

// Get the 2nd page of business units with 5 per page.
$businessUnits = Trustpilot::businessUnits()
    ->limit(5)
    ->page(2)
    ->get();

// Search for the first business unit with the name 'Trustpilot'
$businessUnit = Trustpilot::businessUnits()
    ->search('Trustpilot')
    ->first();

// Get business unit by id
$businessUnit = Trustpilot::businessUnits()->find('46d6a890000064000500e0c3');

// Get the first business unit's first review
$review = Trustpilot::businessUnits()
    ->first()
    ->reviews()
    ->first();

// Get the logo of the searched business.
$logo = Trustpilot::businessUnits()
    ->search('Trustpilot')
    ->first()
    ->logo();

// Get three of your business reviews ordered by lowest star to highest.
$reviews = Trustpilot::businessUnit()
    ->reviews()
    ->orderBy('stars', 'asc')
    ->limit(3)
    ->get();

// Get one of your business reviews which is one star and has a response.
$review = Trustpilot::businessUnit()
    ->reviews()
    ->where('stars', 1)
    ->where('responded', true)
    ->first();

// Get the review title of 5 of your reviews offseted by 5.
$reviews = Trustpilot::businessUnit()
    ->reviews()
    ->limit(5)
    ->offset(5)
    ->get()
    ->pluck('title');

// Get the web links of your business.
$webLinks = Trustpilot::businessUnit()->webLinks();

// Get the logo of your business.
$logo = Trustpilot::businessUnit()->logo();

// Get the customer guarantee of your business.
$customerGuarantee = Trustpilot::businessUnit()->customerGuarantee();

// Get the images of your business.
$images = Trustpilot::businessUnit()->images();

// Get the profile of your business.
$profile = Trustpilot::businessUnit()->profile();

// Get the promotion of your business.
$promotion = Trustpilot::businessUnit()->promotion();
```

### Categories
```php
// Get all categories
$categories = Trustpilot::categories()->get();

// Get categories with a parent of "banking_money"
$categories = Trustpilot::categories()
    ->where('parentId', 'banking_money')
    ->get();

// Get category by id
$category = Trustpilot::categories()->find('trust_bank');

// Get first three business units with the same category as your business unit
$businessUnits = Trustpilot::businessUnit()->categories()->first()->businessUnits()->limit(3)->get();
```

## Credits

- [McCaulay Hudson](https://github.com/mccaulay)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
