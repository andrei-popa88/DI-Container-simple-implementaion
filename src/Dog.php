<?php

namespace Andreip\Dicontainer;

class Dog extends AbstractAnimal
{
    private string $speakWord;
    private string $name;
    private Food $food;
    private bool $hasChip;

    public function __construct(Food $food, string $speakWord, string $name, bool $hasChip = true)
    {
        $this->hasChip = $hasChip;
        $this->food = $food;
        $this->speakWord = $speakWord;
        $this->name = $name;
    }

    public function hasChip(): bool
    {
        return $this->hasChip;
    }

    public function speak(): string
    {
        return sprintf("%s says %s and then eats %s", $this->name, $this->speakWord, $this->food->getFood());
    }
}
