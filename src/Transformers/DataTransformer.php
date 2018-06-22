<?php

namespace Railroad\Response\Transformers;

use League\Fractal\TransformerAbstract;

class DataTransformer extends TransformerAbstract
{
    public function transform($data)
    {
        return $data->getArrayCopy();
    }
}