<?php

namespace Andreip\Dicontainer;

class Cat extends AbstractAnimal
{
    private string $speakWord;
    private string $name;
    private Food $food;

    public function __construct(Food $food, string $speakWord, string $name) {
        $this->food = $food;
        $this->speakWord = $speakWord;
        $this->name = $name;
    }

    public function speak() : string
    {
        return sprintf("%s says %s and then eats %s", $this->name, $this->speakWord, $this->food->getFood());
    }
}