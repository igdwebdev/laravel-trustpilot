<?php
namespace IGD\Trustpilot\Api\Consumer;

use IGD\Trustpilot\Api\Api;

class ConsumerApi extends Api
{
    /**
     * Initialise the consumers api.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setPath('/consumers');
    }

    /**
     * Find a consumer (reviewer) by id.
     *
     * @param string $id
     * @return \IGD\Trustpilot\Api\Consumer\Consumer
     */
    public function find(string $id): Consumer
    {
        return (new Consumer())->data($this->get('/' . $id));
    }
}
