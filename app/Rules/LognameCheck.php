<?php

namespace App\Rules;

use App\CoreForm;
use App\CoreCrud;
use App\CoreLoad;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Validation\Rule;

class LognameCheck implements Rule
{

    /*
    *
    * Validate Email/Username (Logname)
    * This function is used to validate if user email/logname already is used by another account
    * Call this function to validate if nedited logname or email does not belong to another user
    */
    private $CoreForm;
    private $CoreCrud;
    private $CoreLoad;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //Models
        $this->CoreForm = new CoreForm;
        $this->CoreCrud = new CoreCrud;
        $this->CoreLoad = new CoreLoad;
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

        $check = (filter_var($value, FILTER_VALIDATE_EMAIL))? 'email' : 'logname'; //Look Email / Phone Number
        if (strtolower($value) == strtolower(trim($this->CoreCrud->selectSingleValue('user',$check,array('id'=>session()->get($this->CoreForm->sessionName('id'))))))) {
            return true;
        }elseif ($this->CoreLoad->auth('users')) {
            return true;
        }elseif (!$this->CoreCrud->selectSingleValue('user','id',array($check=>$value))) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Already in use by another account';
    }
}
