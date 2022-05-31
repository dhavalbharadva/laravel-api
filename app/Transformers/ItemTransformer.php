<?php

namespace App\Transformers;

class ItemTransformer extends Transformer
{

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */

    public function transform($data)
    {
        $data->makeHidden('created_at');
        $data->makeHidden('updated_at');

        return $data;
    }

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */

    public function transformOrder($data)
    {
        return  $data->title;
        
    }
}
