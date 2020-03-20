<?php
namespace McCaulay\Trustpilot\API\BusinessUnit\Review;

use Illuminate\Support\Collection;
use McCaulay\Trustpilot\Api;
use McCaulay\Trustpilot\API\BusinessUnit\Review;
use McCaulay\Trustpilot\Query\Queryable;

class ReviewApi extends Api implements Queryable
{
    /**
     * The business unit id.
     *
     * @var int
     */
    public $businessUnitId = null;

    /**
     * Initialise the business unit reviews with an optional business unit id.
     * If no business unit id is given, it uses the business unit from the config.
     *
     * @param null|string $businessUnitId
     */
    public function __construct(?string $businessUnitId = null)
    {
        parent::__construct();
        $this->businessUnitId = $businessUnitId ?? config('trustpilot.unit_id');
        $this->setPath('/business-units/' . $this->businessUnitId);
    }

    /**
     * Perform the query and get the results.
     *
     * @param array $query
     * @return \Illuminate\Support\Collection;
     */
    public function perform(array $query): Collection
    {
        $response = $this->get('/reviews', $query);
        return collect($response->reviews)->map(function ($review) {
            return (new Review())->data($review);
        });
    }
}
