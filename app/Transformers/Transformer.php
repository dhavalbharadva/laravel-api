<?php

namespace App\Transformers;

abstract class Transformer {

    /**
     * Transform items
     *
     * @param array $items
     * @return array
     */
    public function transformCollection(array $items) {

        return array_map([$this, 'transform'], $items);
    }

    public abstract function transform($item);

    /**
     * Transform given date time to a time stamp
     * @param $date_time
     * @return int
     */
    public function toTimeStamp($date_time) {
        $date = new \DateTime($date_time);
        return $date->getTimestamp();
    }

}
