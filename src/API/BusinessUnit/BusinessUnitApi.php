<?php
namespace McCaulay\Trustpilot\API\BusinessUnit;

use Illuminate\Support\Collection;
use McCaulay\Trustpilot\Api;
use McCaulay\Trustpilot\API\BusinessUnit\BusinessUnit;
use McCaulay\Trustpilot\Query\Queryable;

class BusinessUnitApi extends Api implements Queryable
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
     * Get the business.
     *
     * @param string $businessUnitId
     * @return mixed
     */
    public function find(string $businessUnitId)
    {
        return $this->get('/' . $businessUnitId);
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
        return $this->get('/' . $businessUnitId . '/categories', array_filter([
            'country' => $country,
            'locale' => $locale,
        ]))->categories;
    }

    /**
     * Get the business web links.
     *
     * @param string $businessUnitId
     * @param string $locale
     * @return mixed
     */
    public function webLinks(string $businessUnitId, string $locale = 'en-US')
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