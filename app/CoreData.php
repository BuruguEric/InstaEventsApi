<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoreData extends Model
{


    /* Model Instances */
    private $CoreCrud;
    private $CoreForm;

    /*
	*
	* To load libraries/Model/Helpers/Add custom code which will be used in this Model
	* This can ease the loading work
	*
	*/
    public function __construct(){


        //libraries

        //Helpers

        //Models
        $this->CoreCrud = new CoreCrud;
        $this->CoreForm = new CoreForm;

        // Your own constructor code

    }

}
