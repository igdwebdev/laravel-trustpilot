<?php
namespace McCaulay\Trustpilot\API\BusinessUnit;

use McCaulay\Trustpilot\Api;
use McCaulay\Trustpilot\API\BusinessUnit\Review\Product\ProductReviewSummary;
use McCaulay\Trustpilot\Query\Builder;

class ProductApi extends Api
{
    /**
     * The business unit id.
     *
     * @var int
     */
    public $businessUnitId = null;

    /**
     * Initialise the business unit product reviews with an optional business unit id.
     * If no business unit id is given, it uses the business unit from the config.
     *
     * @param null|string $businessUnitId
     */
    public function __construct(?string $businessUnitId = null)
    {
        parent::__construct();
        $this->businessUnitId = $businessUnitId ?? config('trustpilot.unit_id');
    }

    /**
     * Get the queried product reviews.
     *
     * @return \McCaulay\Trustpilot\Query\Builder
     */
    public function reviews(): Builder
    {
        return new Builder(new Review\Product\ProductReviewApi($this->businessUnitId));
    }

    /**
     * Get the joint products review summary.
     *
     * @param array $skus
     * @param array $urls
     * @return mixed
     */
    public function reviewSummary(array $skus = [], array $urls = [])
    {
        $response = $this->get('/product-reviews/business-units/' . $this->businessUnitId, array_filter([
            'sku' => $skus,
            'productUrl' => $urls,
        ]));

        return (new ProductReviewSummary())->data($response);
    }

    /**
     * Get the aggregated business product review summaries.
     *
     * @param array $skus
     * @param string $locale
     * @return mixed
     */
    public function reviewAggregatedSummaries(array $skus = [], string $locale = 'en-GB')
    {
        $response = $this->post('/product-reviews/business-units/' . $this->businessUnitId . '/attribute-summaries', [], array_filter([
            'skus' => $skus,
            'locale' => $locale,
        ]));

        return collect($response->summaries)->map(function ($summary) {
            return (new ProductReviewSummary())->data($summary);
        });
    }

    /**
     * Get the business product review summaries.
     *
     * @param array $skus
     * @return mixed
     */
    public function reviewBatchSummaries(array $skus = [])
    {
        $response = $this->post('/product-reviews/business-units/' . $this->businessUnitId . '/batch-summaries', [], array_filter([
            'skus' => $skus,
        ]));

        return collect($response->summaries)->map(function ($summary) {
            return (new ProductReviewSummary())->data($summary);
        });
    }
}
