<?php
namespace IGD\Trustpilot\API\Category\BusinessUnit;

use IGD\Trustpilot\API\BusinessUnit\BusinessUnit;
use IGD\Trustpilot\API\ResourceApi;
use Illuminate\Support\Collection;

class BusinessUnitApi extends ResourceApi
{
    /**
     * The category id.
     *
     * @var int
     */
    public $categoryId = null;

    /**
     * Initialise the category business units with an category id.
     *
     * @param string $categoryId
     */
    public function __construct(string $categoryId)
    {
        parent::__construct();
        $this->categoryId = $categoryId;
        $this->setPath('/categories/' . $this->categoryId);
    }

    /**
     * Perform the query and get the results.
     *
     * @param array $query
     * @param bool $search
     * @return \Illuminate\Support\Collection;
     */
    public function perform(array $query, bool $search = false): Collection
    {
        // Country is required...
        if (!isset($query['country'])) {
            $query['country'] = 'GB';
        }

        $response = $this->get('/business-units', $query);
        return collect($response->businessUnits)->map(function ($businessUnit) {
            return (new BusinessUnit())->data($businessUnit);
        });
    }
}
