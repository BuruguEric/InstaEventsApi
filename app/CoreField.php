<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CoreField extends Model
{

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

        // Your own constructor code

    }

    /*
    *
    * This function is used to load all data requred to be present for the system/website to oparate well
    * E.g Site Menu, Meta Data e.t.c
    * All values are return as one array (data)
    *
    */
    public function loadData()
    {
        //Values Assets

        //Loading Demo
        $data['demo_load'] = 'Delete These';

        //returned DATA

        return $data;
    }

}
