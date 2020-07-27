<?php
namespace IGD\Trustpilot\API\BusinessUnit;

use IGD\Trustpilot\API\BusinessUnit\Product\ProductApi;
use IGD\Trustpilot\API\BusinessUnit\Review\Invitation\InvitationApi;
use IGD\Trustpilot\API\Resource;
use IGD\Trustpilot\Query\Builder;

class BusinessUnit extends Resource
{
    /**
     * The business unit id.
     *
     * @var int
     */
    public $id = null;

    /**
     * Initialise the business unit with an optional business unit id.
     * If no business unit id is given, it uses the business unit from the config.
     *
     * @param null|string $businessUnitId
     */
    public function __construct(?string $businessUnitId = null)
    {
        $this->id = $businessUnitId ?? config('trustpilot.unit_id');
    }

    /**
     * Get the queried reviews.
     *
     * @return \IGD\Trustpilot\Query\Builder
     */
    public function reviews(): Builder
    {
        return new Builder(new Review\ReviewApi($this->id));
    }

    /**
     * Get the product api.
     *
     * @return \IGD\Trustpilot\API\BusinessUnit\Product\ProductApi
     */
    public function products(): ProductApi
    {
        return new ProductApi($this->id);
    }

    /**
     * Get the invitation api.
     *
     * @return \IGD\Trustpilot\API\BusinessUnit\Review\Invitation\InvitationApi
     */
    public function invitation(): InvitationApi
    {
        return new InvitationApi($this->id);
    }

    /**
     * Load the business information.
     *
     * @return self
     */
    public function load()
    {
        return $this->data((new BusinessUnitApi())->find($this->id));
    }

    /**
     * Get the business categories.
     *
     * @param string $country
     * @param string $locale
     * @return mixed
     */
    public function categories(string $country = null, string $locale = null)
    {
        return (new BusinessUnitApi())->categories($this->id, $country, $locale);
    }

    /**
     * Get the business web link.
     *
     * @param string $locale
     * @return mixed
     */
    public function webLinks(string $locale = 'en-GB')
    {
        return (new BusinessUnitApi())->webLinks($this->id, $locale);
    }

    /**
     * Get the business images.
     *
     * @return mixed
     */
    public function images()
    {
        return (new BusinessUnitApi())->images($this->id);
    }

    /**
     * Get the business logo.
     *
     * @return mixed
     */
    public function logo()
    {
        return (new BusinessUnitApi())->logo($this->id);
    }

    /**
     * Get the business customer guarantee.
     *
     * @return mixed
     */
    public function customerGuarantee()
    {
        return (new BusinessUnitApi())->customerGuarantee($this->id);
    }

    /**
     * Get the business profile.
     *
     * @return mixed
     */
    public function profile()
    {
        return (new BusinessUnitApi())->profile($this->id);
    }

    /**
     * Get the business promotion.
     *
     * @return mixed
     */
    public function promotion()
    {
        return (new BusinessUnitApi())->promotion($this->id);
    }
}
