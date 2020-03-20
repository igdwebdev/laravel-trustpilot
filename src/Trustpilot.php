<?php
namespace McCaulay\Trustpilot;

use McCaulay\Trustpilot\API\BusinessUnit\BusinessUnit;
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

    /**
     * Get the default business unit.
     *
     * @return \McCaulay\Trustpilot\API\BusinessUnit\BusinessUnit
     */
    public function businessUnit(): BusinessUnit
    {
        return new BusinessUnit();
    }

    // Trustpilot::businessUnits()->first()->reviews()->first();
    // Trustpilot::businessUnit()->reviews()->first();
    // Trustpilot::businessUnit()->logo();
    // Trustpilot::businessUnit()->customerGuarantee();
    // Trustpilot::businessUnit()->images();
    // Trustpilot::businessUnit()->profile();
    // Trustpilot::businessUnit()->promotion();
}
