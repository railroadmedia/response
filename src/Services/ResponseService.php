<?php

namespace Railroad\Response\Services;

use Railroad\Response\Transformers\DataTransformer;

class ResponseService
{
    /** Transform the data in JSON response
     *
     * @return mixed
     */
    public function getJSONResponse($data)
    {

        return fractal()
            ->collection($data)
            ->transformWith(DataTransformer::class)
            ->toJson();
    }
}