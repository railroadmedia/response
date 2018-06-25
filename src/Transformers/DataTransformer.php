<?php

namespace Railroad\Response\Transformers;

use League\Fractal\TransformerAbstract;
use Railroad\Resora\Entities\Entity;

class DataTransformer extends TransformerAbstract
{
    public function transform(Entity $data)
    {
        return $data->getArrayCopy();
    }
}
