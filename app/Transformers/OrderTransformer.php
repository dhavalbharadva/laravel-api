<?php

namespace App\Transformers;

class OrderTransformer extends Transformer
{

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */

    public function transform($data)
    {

        $this->orderDetailTransformer = new OrderDetailTransformer();
        
        foreach ($data as $key => $value) {
            $data->orderDetail = $this->orderDetailTransformer->transform($value->orderDetail);
        }
        
        return $data;
    }
}
