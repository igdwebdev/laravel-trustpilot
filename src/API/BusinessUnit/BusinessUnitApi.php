<?php
namespace McCaulay\Trustpilot\API\BusinessUnit;

use Illuminate\Support\Collection;
use McCaulay\Trustpilot\Api;
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
     * @return \Illuminate\Support\Collection;
     */
    public function perform(array $query): Collection
    {
        $result = $this->get('all', $query);
    }
}
