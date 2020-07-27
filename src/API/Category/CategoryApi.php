<?php
namespace IGD\Trustpilot\API\Category;

use IGD\Trustpilot\API\ResourceApi;
use Illuminate\Support\Collection;

class CategoryApi extends ResourceApi
{
    /**
     * Initialise the categories api
     */
    public function __construct()
    {
        parent::__construct();
        $this->setPath('/categories');
    }

    /**
     * Perform the query and get the results.
     *
     * @param array $query
     * @param bool $search
     * @return \Illuminate\Support\Collection
     */
    public function perform(array $query, bool $search = false): Collection
    {
        $response = $this->get('', $query);
        return collect($response->categories)->map(function ($category) {
            return (new Category())->data($category);
        });
    }

    /**
     * Find the item from the id.
     *
     * @param string $id
     * @param array $params
     * @return mixed
     */
    public function find(string $id, array $params = [])
    {
        // Country is required...
        if (!isset($params['country'])) {
            $params['country'] = 'GB';
        }
        $category = $this->get('/' . $id, $params);
        return (new Category())->data($category);
    }
}
