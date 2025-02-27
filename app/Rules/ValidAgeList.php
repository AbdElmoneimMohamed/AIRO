<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidAgeList implements Rule
{
    /**
     * Determine if the validation rule passes.
     */
    public function passes($attribute, $value): bool
    {
        if (! is_string($value) || ! preg_match('/^(\d{1,2})(,\d{1,2})*$/', $value)) {
            return false;
        }

        $ages = explode(',', $value);
        foreach ($ages as $age) {
            if ($age < 18 || $age > 70) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'The age field must be a comma-separated list of valid ages between 18 and 70.';
    }
}
