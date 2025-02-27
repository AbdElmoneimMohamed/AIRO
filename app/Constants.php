<?php

declare(strict_types=1);

namespace App;

interface Constants
{
    public const FIXED_RATE = 3;

    public const AGE_BRACKETS = [
        [
            'min' => 18,
            'max' => 30,
            'load' => 0.6,
        ],
        [
            'min' => 31,
            'max' => 40,
            'load' => 0.7,
        ],
        [
            'min' => 41,
            'max' => 50,
            'load' => 0.8,
        ],
        [
            'min' => 51,
            'max' => 60,
            'load' => 0.9,
        ],
        [
            'min' => 61,
            'max' => 70,
            'load' => 1.0,
        ],
    ];
}
