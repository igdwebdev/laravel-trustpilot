<?php
namespace McCaulay\Trustpilot;

use McCaulay\Trustpilot\Query\Builder;

class Trustpilot
{
    /**
     * Get the business unit query builder.
     *
     * @return \McCaulay\Trustpilot\Query\Builder
     */
    public function businessUnits(): Builder
    {
        return new Builder(new BusinessUnit\BusinessUnitApi());
    }

    // Trustpilot::businessUnits()->reviews()->first();
}
