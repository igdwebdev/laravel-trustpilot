<?php
namespace McCaulay\Trustpilot\Query;

use Illuminate\Support\Collection;

interface Queryable
{
    /**
     * Perform the query and get the results.
     *
     * @param array $query
     * @return \Illuminate\Support\Collection;
     */
    public function perform(array $query): Collection;
}
