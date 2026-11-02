<?php
namespace IGD\Trustpilot\Api\BusinessUnit\Review;

use IGD\Trustpilot\Api\ResourceApi;
use Illuminate\Support\Collection;

class PrivateReviewApi extends ResourceApi
{
    /**
     * The business unit id.
     *
     * @var string
     */
    public $businessUnitId = null;

    /**
     * Initialise the private business unit reviews with an optional business unit id.
     * If no business unit id is given, it uses the business unit from the config.
     *
     * Private reviews require OAuth and include fields not available on the public
     * endpoint, such as the invitation referenceId and the consumer's details.
     *
     * @param null|string $businessUnitId
     */
    public function __construct(?string $businessUnitId = null)
    {
        parent::__construct();
        $this->businessUnitId = $businessUnitId ?? config('trustpilot.unit_id');
        $this->setPath('/private/business-units/' . $this->businessUnitId);
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
        $response = $this->get('/reviews', $query, true);
        return collect($response->reviews ?? [])->map(function ($review) {
            return (new Review())->data($review);
        });
    }
}
