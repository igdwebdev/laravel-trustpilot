<?php
namespace McCaulay\Trustpilot\API\BusinessUnit;

use McCaulay\Trustpilot\Query\Builder;

class BusinessUnit
{
    /**
     * The business unit id.
     *
     * @var int
     */
    private $businessUnitId = null;

    /**
     * Initialise the business unit with an optional business unit id.
     * If no business unit id is given, it uses the business unit from the config.
     *
     * @param null|string $businessUnitId
     */
    public function __construct(?string $businessUnitId = null)
    {
        $this->businessUnitId = $businessUnitId ?? config('trustpilot.unit_id');
    }

    /**
     * Get the queried reviews.
     *
     * @return \Illuminate\Support\Collection
     */
    public function reviews(): Collection
    {
        return new Builder(new Review\ReviewApi());
    }
}
