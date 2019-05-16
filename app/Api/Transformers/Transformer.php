<?php

namespace App\Api\Transformers;


use Illuminate\Support\Collection;

abstract class Transformer
{
    /**
     * @param Collection $items
     * @return array
     */
    public function transformCollection(Collection $items)
    {
        return array_map([$this, 'transform'], $items->toArray());
    }

    public abstract function transform(array $item);

}