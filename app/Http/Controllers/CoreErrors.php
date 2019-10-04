<?php

namespace App\Http\Controllers;

use App\CoreLoad;
use App\CoreForm;
use App\CoreCrud;
use App\CoreNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Session\Session;

class CoreErrors extends Controller
{
    /*
    *
    * The main controller for Administrator Backend
    * -> The controller require user to login as Administrator
    */
    private $CoreLoad;
    private $CoreForm;
    private $CoreCrud;
    private $CoreNotify;

    /* Functions
    * -> __construct () = Load the most required operations E.g Class Module
    *
    */
    public function __construct()
    {

        //Models
        $this->CoreLoad = new CoreLoad;
        $this->CoreForm = new CoreForm;
        $this->CoreCrud = new CoreCrud;
        $this->CoreNotify = new CoreNotify;

        //Helpers

        // Your own constructor code

    }
    /*
    *
    * Access Requred pre-loaded data
    * The additional Model based data are applied here from passed function and join with load function
    * The pageID variable can be left as null if you do not wish to access Meta Data values
    * Initially what is passed is a pageID or Page Template Name
    *
    */
    public function loadData($pageID=null)
    {

        //Model

        //Model Query
        $data = $this->CoreLoad->open($pageID);
        $passed = $this->passed();
        $data = array_merge($data,$passed);

        return $data;
    }

    /*
    *
    * Load the model/controller based data here
    * The data loaded here does not affect the other models/controller/views
    * It only can reach and expand to this controller only
    *
    */
    public function passed($values=null)
    {

        //Time Zone
		date_default_timezone_set('Africa/Nairobi');
		$data['str_to_time'] = strtotime(date('Y-m-d, H:i:s'));

        return $data;
    }

    /*
    *
    * This is one of the most important functions in your project
    * All pages used by this controller should be opened using pages function
    * 1: The first passed data is an array containing all pre-loaded data N.B it can't be empty becuase page name is passed through it
    * 2: Layout -> this can be set to default so it can open a particular layout always | also you can pass other layout N.B can't be empty
    *
    * ** To some page functions which are not public, use the auth method from CoreLoad model to check is user is allowed to access the pages
    * ** If your page is public ignore the use of auth method
    *
    */
    public function pages($data,$layout='error')
    {
        //Layout
        return view("admin/layouts/$layout",$data);
    }

    /*
    *
    * This is the first function to be accessed when a user open this controller
    * In here we can call the load function and pass data to passed as an array inorder to manupulate it inside passed function
    * 	* Set your Page name/ID here N:B Page ID can be a number if you wish to access other values linked to the page opened E.g Meta Data
    * 	* You can also set Page ID as actual pageName found in your view N:B do not put .php E.g home.php it should just be 'home'
    * 	* Set Page template
    * 	* Set Notification here
    * 	By Default index does not allow notification Message to be passed, it uses the default message howevr you can pass using the notifyMessage variable
    * 	However we advise to use custom notification message while opening index utilize another function called open
	*
    */
    public function index($notifyMessage='Sorry Page Was Not Found 404:')
    {

        //Model Query
        $data = $this->loadData('error');
		$message = 'Sorry Page Was Not Found 404:';

        //Notification
        $notify = $this->CoreNotify->notify();
        $data['notify'] = $this->CoreNotify->$notify($notifyMessage);
		$data['message'] = $message; //Error Message

        //Open Page
        return $this->pages($data);
    }

    /*
    *
    * This is the function to be accessed when a user want to open specific page which deals with same controller E.g Edit data after saving
    * In here we can call the load function and pass data to passed as an array inorder to manupulate it inside passed function
    * 	* Set your Page name/ID here N:B Page ID can be a number if you wish to access other values linked to the page opened E.g Meta Data
    * 	* You can also set Page ID as actual pageName found in your view N:B do not put .php E.g home.php it should just be 'home'
    * 	* Set Page template
    * 	* Set Notification here
    * 	Custom notification message can be set/passed via $message
    * 	PageName / ID can be passed via $pageID
    * 	Page layout can be passed via $layout
	*
    */
    public function open($pageID='error',$message='You do not have permission to access this page',$layout='error')
    {

        //Model Query
        $data = $this->loadData($pageID);

        //Notification
        $notify = $this->CoreNotify->notify();
        $data['notify'] = $this->CoreNotify->$notify($message);
		$data['message'] = $message;

        //Open Page
        return $this->pages($data,$layout);
    }
}
