<?php
namespace IGD\Trustpilot;

use IGD\Trustpilot\API\BusinessUnit\BusinessUnit;
use IGD\Trustpilot\API\BusinessUnit\BusinessUnitApi;
use IGD\Trustpilot\API\BusinessUnit\Product\ProductApi;
use IGD\Trustpilot\API\Category\CategoryApi;
use IGD\Trustpilot\Query\Builder;

class Trustpilot
{
    /**
     * Get the default business unit.
     *
     * @param string|null $businessUnitId
     * @return \IGD\Trustpilot\API\BusinessUnit\BusinessUnit
     */
    public function businessUnit(?string $businessUnitId = null): BusinessUnit
    {
        return new BusinessUnit($businessUnitId);
    }

    /**
     * Get the business unit query builder.
     *
     * @return \IGD\Trustpilot\Query\Builder
     */
    public function businessUnits(): Builder
    {
        return new Builder(new BusinessUnitApi());
    }

    /**
     * Get the product query builder.
     *
     * @return \IGD\Trustpilot\Query\Builder
     */
    public function products(): Builder
    {
        return (new Builder(new ProductApi()))->setArrayAsComma();
    }

    /**
     * Get the category query builder.
     *
     * @return \IGD\Trustpilot\Query\Builder
     */
    public function categories(): Builder
    {
        return new Builder(new CategoryApi());
    }
}
