<?php

namespace App\Model\Entity;

use App\Model\Traits\Hydrator;

abstract class BaseEntity implements \JsonSerializable
{

    protected ?int $id = null;

    use Hydrator;

    public function __construct(array $data = [])
    {
        $this->hydrate($data);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        return $this->id = $id;
    }
    
    public function jsonSerialize(): mixed
    {
        $reflection = new \ReflectionClass($this);
        $atts = [];

        foreach ($reflection->getProperties() as $property) {
            $atts[$property->getName()] = $property->getValue($this);
        }

        return $atts;
    }
}
