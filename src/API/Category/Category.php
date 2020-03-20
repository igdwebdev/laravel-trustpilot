<?php
namespace McCaulay\Trustpilot\API\Category;

use McCaulay\Trustpilot\API\Resource;
use McCaulay\Trustpilot\Query\Builder;

class Category extends Resource
{
    /**
     * Get the queried business units in the category.
     *
     * @return \McCaulay\Trustpilot\Query\Builder
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
