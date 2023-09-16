<?php

namespace Andreip\Dicontainer;

class Food {
    private Pork $pork;
    private Seasoning $seasoning;

    public function __construct(Pork $pork, Seasoning $seasoning)
    {
        $this->pork = $pork;
        $this->seasoning = $seasoning;
    }

    public function getFood() : string
    {
        return sprintf("%s with %s", $this->pork->getIngredient(),  $this->seasoning->getSeasoning());
    }
}