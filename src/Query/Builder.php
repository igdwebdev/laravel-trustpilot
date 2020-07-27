<?php
namespace IGD\Trustpilot\Query;

use IGD\Trustpilot\Query\Queryable;
use Illuminate\Support\Collection;

class Builder
{
    /**
     * The queryable resource.
     *
     * @var \IGD\Trustpilot\Query\Queryable
     */
    private $queryable;

    /**
     * The where conditions to restrict the results.
     *
     * @var array
     */
    private $where = [];

    /**
     * Order the results by a column, ascending or descending.
     *
     * @var array
     */
    private $order = [];

    /**
     * The number of items to pull back per page.
     *
     * @var null|int
     */
    private $limit = null;

    /**
     * The page to pull back.
     *
     * @var null|int
     */
    private $page = null;

    /**
     * The offset.
     *
     * @var null|int
     */
    private $offset = null;

    /**
     * The array type.
     * 1 - Array
     * 2 - Comma Seperated
     *
     * @var int
     */
    private $arrayType = 1/*Array*/;

    /**
     * Initialise the builder with a queryable resource.
     *
     * @param \IGD\Trustpilot\Query\Queryable $queryable
     */
    public function __construct(Queryable $queryable)
    {
        $this->queryable = $queryable;
    }

    /**
     * Build the query.
     *
     * @return array
     */
    private function build(): array
    {
        $query = [];

        // Append where conditions
        if (!empty($this->where)) {
            foreach ($this->where as $key => $value) {
                // Convert boolean value to string
                if (is_bool($value)) {
                    $value = $value ? 'true' : 'false';
                }

                // Handle date time format
                if ($value instanceof \DateTime) {
                    $value = $value->format('Y-m-d\TH:i:s');
                }

                // Handle comma seperated array
                if (is_array($value) && $this->arrayType == 2/*Comma*/) {
                    $value = implode(',', $value);
                }

                // Set key / value
                $query[$key] = $value;
            }
        }

        // Append order by
        if (!empty($this->order)) {
            $query['orderBy'] = $this->order;
        }

        // Append limit
        if (!empty($this->limit)) {
            $query['perPage'] = $this->limit;
        }

        // Append page
        if (!empty($this->offset) || !empty($this->page)) {
            if (!empty($this->offset)) {
                $this->page = floor($this->offset / $this->limit) + 1;
            }

            $query['page'] = $this->page;
        }

        return $query;
    }

    /**
     * Get the queried items.
     *
     * @return \Illuminate\Support\Collection
     */
    public function get(): Collection
    {
        return $this->queryable->perform($this->build());
    }

    /**
     * Search the queried items.
     *
     * @param string $value
     * @return \Illuminate\Support\Collection
     */
    public function search(string $value): Collection
    {
        $query = $this->build();
        $query['query'] = $value;
        return $this->queryable->perform($query, true);
    }

    /**
     * Find the item.
     *
     * @param string $id
     * @param array $params
     * @return mixed
     */
    public function find(string $id, array $params = [])
    {
        return $this->queryable->find($id, $params);
    }

    /**
     * Get all the items.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all(): Collection
    {
        return $this->page(null)
            ->offset(null)
            ->limit(null)
            ->get();
    }

    /**
     * Get the first item.
     *
     * @return mixed
     */
    public function first()
    {
        return $this->page(null)
            ->offset(null)
            ->limit(1)
            ->get()
            ->first();
    }

    /**
     * Restrict the query by a where condition.
     *
     * @param string $field
     * @param string|array $value
     * @return \IGD\Trustpilot\Query\Builder
     */
    public function where(string $field, $value): Builder
    {
        $this->where[$field] = $value;
        return $this;
    }

    /**
     * Set the order.
     *
     * @param string $field
     * @param string $order ("asc" or "desc")
     * @return \IGD\Trustpilot\Query\Builder
     */
    public function orderBy(string $field, string $order): Builder
    {
        $this->order[] = strtolower($field) . '.' . strtolower($order);
        return $this;
    }

    /**
     * Set the limit.
     *
     * @param null|int $limit
     * @return \IGD\Trustpilot\Query\Builder
     */
    public function limit(?int $limit): Builder
    {
        // Handle boundaries
        if ($limit < 1 || $limit > 100) {
            $limit = null;
        }

        $this->limit = $limit;
        return $this;
    }

    /**
     * Set the page.
     *
     * @param null|int $page
     * @return \IGD\Trustpilot\Query\Builder
     */
    public function page(?int $page): Builder
    {
        // Handle boundaries
        if ($page < 1) {
            $page = null;
        }

        $this->page = $page;
        return $this;
    }

    /**
     * Set the offset.
     *
     * @param null|int $offset
     * @return \IGD\Trustpilot\Query\Builder
     */
    public function offset(?int $offset): Builder
    {
        // Handle boundaries
        if ($offset < 1) {
            $offset = null;
        }

        $this->offset = $offset;
        return $this;
    }

    /**
     * Set the array type as an array.
     *
     * @return \IGD\Trustpilot\Query\Builder
     */
    public function setArrayAsArray(): Builder
    {
        $this->arrayType = 1/*Array*/;
        return $this;
    }

    /**
     * Set the array type as comma seperated.
     *
     * @return \IGD\Trustpilot\Query\Builder
     */
    public function setArrayAsComma(): Builder
    {
        $this->arrayType = 2/*Comma*/;
        return $this;
    }
}
