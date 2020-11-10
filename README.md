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
TRUSTPILOT_API_KEY=
TRUSTPILOT_API_SECRET=
TRUSTPILOT_USERNAME=
TRUSTPILOT_PASSWORD=
```

## TO-DO
- Consumer API
- Consumer Profile API
- Product Reviews API -> Conversations, Invitation Link
- Resources API
- Service Reviews API
- Business Units API (Private Reviews)

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

// Get the the first 10 product reviews of your business that are 4 or 5 stars for the specific products.
$productReviews = Trustpilot::businessUnit()
    ->products()->reviews()
    ->where('sku', [
        'product_1_sku_here',
        'product_2_sku_here',
    ])
    ->where('stars', [4, 5])
    ->limit(10)
    ->get();

// Get the joined product review summary of the two specific products for your business.
$productReviewSummary = Trustpilot::businessUnit()
    ->products()
    ->reviewSummary([
        'product_1_sku_here',
        'product_2_sku_here',
    ]);

// Get the joined product review summary of the two specific products for your business by URL.
$productReviewSummary = Trustpilot::businessUnit()
    ->products()
    ->reviewSummary([], [
        'https://www.example.com/product_1',
        'https://www.example.com/product_2',
    ]);

// Get the aggregated product review summary of the two specific products for your business.
$aggregatedProductReviewSummaries = Trustpilot::businessUnit()
    ->products()
    ->reviewAggregatedSummaries([
        'product_1_sku_here',
        'product_2_sku_here',
    ]);

// Get the batched product review summary of the two specific products for your business.
$productReviewSummaries = Trustpilot::businessUnit()
    ->products()
    ->reviewBatchSummaries([
        'product_1_sku_here',
        'product_2_sku_here',
    ]);

// Get three of your business imported reviews for the given product.
$reviews = Trustpilot::businessUnit()
    ->importedReviews()
    ->where('sku', 'product_sku_here')
    ->limit(3)
    ->get();

// Get five of your business imported reviews for the given products.
$reviews = Trustpilot::businessUnit()
    ->importedReviews()
    ->where('sku', [
        'product_1_sku_here',
        'product_2_sku_here',
    ])
    ->limit(5)
    ->get();

// Get the joined imported product review summary of the two specific products for your business.
$productReviewSummary = Trustpilot::businessUnit()
    ->products()
    ->importedReviewSummary([
        'product_1_sku_here',
        'product_2_sku_here',
    ]);

// Get the joined imported product review summary of the specific product for your business.
$productReviewSummary = Trustpilot::businessUnit()
    ->products()
    ->importedReviewSummary('product_1_sku_here');

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

### Products
```php
// Get all products.
$products = Trustpilot::products()->get();

// Get the product with a sku of "samsung-galaxy-s10".
$product = Trustpilot::products()
    ->where('skus', 'samsung-galaxy-s10')
    ->first();

// Get all products with a sku of "samsung-galaxy-s8", "samsung-galaxy-s9" or "samsung-galaxy-s10".
$products = Trustpilot::products()
    ->where('skus', ['samsung-galaxy-s8', 'samsung-galaxy-s9', 'samsung-galaxy-s10'])
    ->get();

// Updating a product.
$product = Trustpilot::products()
    ->where('skus', 'samsung-galaxy-s10')
    ->first();
$product->title = 'Samsung Galaxy S10';
$product->price = '9.99';
$product->currency = 'USD';
$product->save();
```

### Inivitations
```php
// Create a service invitation to John Doe from Business Name now.
Trustpilot::businessUnit()->invitation()->service(
    '#123456', 'John Doe', 'john.doe@example.com',
    'no-reply@business.com', 'Business Name'
);

// Create a service invitation to John Doe from Business Name now to be sent
// in 5 days using a custom template id and to redirect to our website afterwards.
Trustpilot::businessUnit()->invitation()->service(
    '#123456', 'John Doe', 'john.doe@example.com',
    'no-reply@business.com', 'Business Name', 'support@business.com',
    \Carbon\Carbon::now()->addDays(5), '507f191e810c19729de860ea',
    'https://example.com/',
);

// Create a product and service invitation from product skus.
Trustpilot::businessUnit()->invitation()->products(
    ['samsung-galaxy-s8', 'samsung-galaxy-s9', 'samsung-galaxy-s10'],
    '#123456', 'John Doe', 'john.doe@example.com',
    'no-reply@business.com', 'Business Name'
);

// Create a product and service invitation from products.
Trustpilot::businessUnit()->invitation()->products(
    [
        new Product([
            'sku' => 'samsung-galaxy-s8',
            'name' => 'Samsung Galaxy S8',
            'brand' => 'Samsung Galaxy',
            'productUrl' => 'https://example.com/products/samsung-galaxy-s8',
            'imageUrl' => 'https://example.com/products/images/samsung-galaxy-s8.jpg',
        ]),
        new Product([
            'sku' => 'samsung-galaxy-s10',
            'name' => 'Samsung Galaxy S10',
            'brand' => 'Samsung Galaxy',
            'productUrl' => 'https://example.com/products/samsung-galaxy-s10',
            'imageUrl' => 'https://example.com/products/images/samsung-galaxy-s10.jpg',
        ]),
    ],
    '#123456', 'John Doe', 'john.doe@example.com',
    'no-reply@business.com', 'Business Name'
);

// Get a list of templates available to be used in invitations.
$templates = Trustpilot::businessUnit()->invitation()->templates();

// Generate a service review invitation link.
$inviteUrl = Trustpilot::businessUnit()->invitation()->generateLink('#123456', 'John Doe', 'john.doe@example.com', 'https://example.com/');

// Delete all invitation data related to the given e-mails.
Trustpilot::businessUnit()->invitation()->deleteByEmails([
    'john.doe@example.com',
    'jane.doe@example.com',
]);

// Delete all invitation data older than 5 years.
Trustpilot::businessUnit()->invitation()->deleteBeforeDate(\Carbon\Carbon::now()->subYears(5));
```

### Categories
```php
// Get all categories.
$categories = Trustpilot::categories()->get();

// Get categories with a parent of "banking_money".
$categories = Trustpilot::categories()
    ->where('parentId', 'banking_money')
    ->get();

// Get category by id.
$category = Trustpilot::categories()->find('trust_bank');

// Get first three business units with the same category as your business unit.
$businessUnits = Trustpilot::businessUnit()->categories()->first()->businessUnits()->limit(3)->get();
```

## Credits

- [McCaulay Hudson](https://github.com/mccaulay)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
