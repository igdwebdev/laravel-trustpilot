<?php
namespace IGD\Trustpilot\API\Category;

use IGD\Trustpilot\API\Resource;
use IGD\Trustpilot\Query\Builder;

class Category extends Resource
{
    /**
     * Get the queried business units in the category.
     *
     * @return \IGD\Trustpilot\Query\Builder
     */
    public function businessUnits(): Builder
    {
        return new Builder(new BusinessUnit\BusinessUnitApi($this->categoryId));
    }

    /**
     * Load the category information.
     *
     * @return self
     */
    public function load()
    {
        return $this->data((new CategoryApi())->find($this->categoryId));
    }
}
