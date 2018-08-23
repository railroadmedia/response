<?php

namespace Railroad\Response\Services;

use ArrayObject;
use Illuminate\Http\Request;
use Railroad\Response\Transformers\DataTransformer;
use Railroad\Resora\Collections\BaseCollection;
use Traversable;

class ResponseService
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function form($successMessages = [true], $redirectLocation = null, $errorMessages = [], $results = [])
    {
        $next = $redirectLocation ?? $this->request->get('redirect');

        /** @var \Illuminate\Http\RedirectResponse $redirectResponse */
        $redirectResponse = $next ? redirect()->away($next) :
            redirect()->back();

        foreach ($successMessages as $message) {
            $redirectResponse->with('success', $message);
        }

        foreach ($errorMessages as $message) {
            $redirectResponse->with('error', $message);
        }

        foreach($results as $key => $value)
        {
            $redirectResponse->with($key, $value);
        }

        return $redirectResponse;
    }

    /**
     * @param mixed $data
     * @param array $options response options with follwing keys
     * 'transformer'   - string - The transformer to be used, default \Railroad\Response\Transformers\DataTransformer
     * 'totalResults'  - int    - if the collection represents a page of results, this represents the total results count
     * 'filterOptions' - mixed  - TO DO: add description
     * 'errors'        - array  - details of errors, validation errors format: [['source' => 'field', 'detail' => 'error message'], [..], ..]
     * 'meta'          - array  - metadata key/value
     * 'code'          - int    - HTTP code of the response
     * 'headers'       - array  - HTTP response headers key/value
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function json($data, array $options = [])
    {
        // add default options
        $options += [
            'transformer' => DataTransformer::class,
            'meta' => [],
            'code' => 200,
            'headers' => []
        ];

        // handle collection default pagination meta - move from options to options['meta']
        if (isset($options['totalResults'])) {

            $options['meta']['totalResults'] = $options['totalResults'];

            // add page and limit from $this->request
            $options['meta']['page'] = $this->request->get('page', 1);
            $options['meta']['limit'] = $this->request->get('limit', 10);
        }

        if (isset($options['filterOptions'])) {
            $options['meta']['filterOptions'] = $options['filterOptions'];
        }

        // handle errors - move from options to options['meta']
        if (isset($options['errors'])) {
            $options['meta']['errors'] = $options['errors'];
        }

        // handle data: if single Entity instance, or non-array, wrap value in array
        if (
            ($data instanceof ArrayObject) ||
            (!is_array($data) &&
            !($data instanceof Traversable) &&
            !($data instanceof BaseCollection))
        ) {
            $data = $data ? [$data] : [];
        }

        return fractal()
                ->collection($data, $options['transformer'])
                ->addMeta($options['meta'])
                ->respond($options['code'], $options['headers']);
    }
}
