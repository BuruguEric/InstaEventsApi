<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidEmail implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //Check Email
        $find1 = strpos($value, '@');
        $find2 = strpos($value, '.');

        //Return Status
        return ($find1 !== false && $find2 !== false && $find2 > $find1);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Enter a valid email address.';
    }
}
