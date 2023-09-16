<?php

namespace Andreip\Dicontainer;

class AnimalShelter
{
    private AbstractAnimal $abstractAnimal;

    public function __construct(AbstractAnimal $abstractAnimal)
    {
        $this->abstractAnimal = $abstractAnimal;
    }

    public function speakFromAnimalShelter(): string
    {
        return $this->abstractAnimal->speak();
    }
}