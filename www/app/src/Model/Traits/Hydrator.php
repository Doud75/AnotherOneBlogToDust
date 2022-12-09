<?php

namespace App\Model\Traits;

trait Hydrator
{
    public function hydrate(array $data): void
    {
        foreach ($data as $key => $value) {
            $method = str_replace("_", " ", $key);
            $method = ucwords($method);
            $method =  'set' . str_replace(" ", "", $method);
            if (is_callable([$this, $method])) {
                $this->$method($value);
            }
        }
    }
}

