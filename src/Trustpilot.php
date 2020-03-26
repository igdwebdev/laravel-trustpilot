<?php
namespace McCaulay\Trustpilot;

use McCaulay\Trustpilot\API\BusinessUnit\BusinessUnit;
use McCaulay\Trustpilot\API\BusinessUnit\BusinessUnitApi;
use McCaulay\Trustpilot\API\BusinessUnit\Product\ProductApi;
use McCaulay\Trustpilot\API\Category\CategoryApi;
use McCaulay\Trustpilot\Query\Builder;

class Trustpilot
{
    /**
     * Get the default business unit.
     *
     * @param string|null $businessUnitId
     * @return \McCaulay\Trustpilot\API\BusinessUnit\BusinessUnit
     */
    public function businessUnit(?string $businessUnitId = null): BusinessUnit
    {
        return new BusinessUnit($businessUnitId);
    }

    /**
     * Get the business unit query builder.
     *
     * @return \McCaulay\Trustpilot\Query\Builder
     */
    public function businessUnits(): Builder
    {
        return new Builder(new BusinessUnitApi());
    }

    /**
     * Get the product query builder.
     *
     * @return \McCaulay\Trustpilot\Query\Builder
     */
    public function products(): Builder
    {
        return (new Builder(new ProductApi()))->setArrayAsComma();
    }

    /**
     * Get the category query builder.
     *
     * @return \McCaulay\Trustpilot\Query\Builder
     */
    public function categories(): Builder
    {
        return new Builder(new CategoryApi());
    }
}
