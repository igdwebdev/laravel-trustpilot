<?php
namespace IGD\Trustpilot\API;

use IGD\Trustpilot\API\Api;
use IGD\Trustpilot\Query\Queryable;

abstract class ResourceApi extends Api implements Queryable
{
    /**
     * Find the item from the id.
     *
     * @param string $id
     * @param array $params
     * @return mixed
     */
    public function find(string $id, array $params = [])
    {
        return $this->get('/' . $id, $params);
    }
}
