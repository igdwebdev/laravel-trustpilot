<?php
namespace IGD\Trustpilot\API\BusinessUnit;

use IGD\Trustpilot\API\BusinessUnit\BusinessUnit;
use IGD\Trustpilot\API\Category\Category;
use IGD\Trustpilot\API\ResourceApi;
use Illuminate\Support\Collection;

class BusinessUnitApi extends ResourceApi
{
    /**
     * Initialise the business unit api
     */
    public function __construct()
    {
        parent::__construct();
        $this->setPath('/business-units');
    }

    /**
     * Perform the query and get the results.
     *
     * @param array $query
     * @param bool $search
     * @return \Illuminate\Support\Collection
     */
    public function perform(array $query, bool $search = false): Collection
    {
        $response = $this->get($search ? '/search' : '/all', $query);
        return collect($response->businessUnits)->map(function ($businessUnit) {
            return (new BusinessUnit())->data($businessUnit);
        });
    }

    /**
     * Get the business categories.
     *
     * @param string $businessUnitId
     * @param string $country
     * @param string $locale
     * @return mixed
     */
    public function categories(string $businessUnitId, string $country = null, string $locale = null)
    {
        $response = $this->get('/' . $businessUnitId . '/categories', array_filter([
            'country' => $country,
            'locale' => $locale,
        ]));

        return collect($response->categories)->map(function ($category) {
            return (new Category())->data($category);
        });
    }

    /**
     * Get the business web links.
     *
     * @param string $businessUnitId
     * @param string $locale
     * @return mixed
     */
    public function webLinks(string $businessUnitId, string $locale = 'en-GB')
    {
        return $this->get('/' . $businessUnitId . '/web-links', ['locale' => $locale]);
    }

    /**
     * Get the business images.
     *
     * @param string $businessUnitId
     * @return mixed
     */
    public function images(string $businessUnitId)
    {
        return $this->get('/' . $businessUnitId . '/images');
    }

    /**
     * Get the business logo.
     *
     * @param string $businessUnitId
     * @return mixed
     */
    public function logo(string $businessUnitId)
    {
        return $this->get('/' . $businessUnitId . '/images/logo')->logoUrl;
    }

    /**
     * Get the business customer guarantee.
     *
     * @param string $businessUnitId
     * @return mixed
     */
    public function customerGuarantee(string $businessUnitId)
    {
        return $this->get('/' . $businessUnitId . '/customerguarantee');
    }

    /**
     * Get the business profile.
     *
     * @param string $businessUnitId
     * @return mixed
     */
    public function profile(string $businessUnitId)
    {
        return $this->get('/' . $businessUnitId . '/profileinfo');
    }

    /**
     * Get the business promotion.
     *
     * @param string $businessUnitId
     * @return mixed
     */
    public function promotion(string $businessUnitId)
    {
        return $this->get('/' . $businessUnitId . '/profilepromotion');
    }
}
