<?php

namespace App\Transformers;

class OrderDetailTransformer extends Transformer
{

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */

    protected $hidden = ['updated_at'];

    public function transform($data)
    {
        foreach ($data as $key => $value) {
            $this->itemTransformer = new ItemTransformer();
            $data[$key]['item_title'] = $this->itemTransformer->transformOrder($value->item);
        }
        
        $data->makeHidden('item');
        $data->makeHidden('created_at');
        $data->makeHidden('updated_at');

        return $data;
    }
}
