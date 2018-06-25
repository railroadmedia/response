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

    /**
     * @param mixed $data
     * @param array $options response options with follwing keys
     * 'transformer' - string - The transformer to be used, default \Railroad\Response\Transformers\DataTransformer
     * 'meta'        - array  - metadata key/value
     * 'code'        - int    - HTTP code of the response
     * 'headers'     - array  - HTTP response headers key/value
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function result($data, array $options = []) {

        $options += [
            'transformer' => DataTransformer::class,
            'meta' => [],
            'code' => 200,
            'headers' => []
        ];

        if (
            $data &&
            !is_array($data) &&
            !($data instanceof \Traversable)
        ) {

            $data = [$data];
        }

        return fractal()
                ->collection($data, $options['transformer'])
                ->addMeta($options['meta'])
                ->respond($options['code'], $options['headers']);
    }
}
