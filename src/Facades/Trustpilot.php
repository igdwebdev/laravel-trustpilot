<?php
namespace IGD\Trustpilot\Facades;

use Illuminate\Support\Facades\Facade;

class Trustpilot extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'trustpilot';
    }
}
