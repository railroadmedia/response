<?php

namespace Railroad\Response\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Http\JsonResponse result(mixed $data, array $options = [])
 *
 * @see \Railroad\Response\Services\ResponseService
 */
class Response extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'fractal.response';
    }
}
