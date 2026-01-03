<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EditorEmptyCheckRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $descriptionString =  str_replace('&nbsp;', '', trim(strip_tags($value, '<img>')));
        if(empty($descriptionString)) {
            $fail('The description field is required.');
        }
    }
}
