<?php
// src/TwigExtension/ShuffleExtension.php
namespace App\TwigExtension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ShuffleExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('shuffle', [$this, 'shuffle']),
        ];
    }

    public function shuffle($array)
    {
        $array = $array->toArray();

        shuffle($array);

        return $array;
    }
}