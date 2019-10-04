<?php

namespace App\Http\Controllers;

use App\CoreLoad;
use App\CoreForm;
use App\CoreCrud;
use App\CoreNotify;
use Illuminate\Support\Str;
use Illuminate\Contracts\Session\Session;

class CoreMains extends Controller
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

    private $Core = 'core'; //Core Lite Base Name | Change this if your Controller Name does not start with word Core
    private $Module = 'main'; //Module
    private $Folder = '/* HTML Source Folder Name */'; //Set Default Folder For html files
    private $SubFolder = ''; //Set Default Sub Folder For html files and Front End Use Start withphp /

    private $AllowedFile = null; //Set Default allowed file extension, remember you can pass this upon upload to override default allowed file type. Allowed File Extensions Separated by | also leave null to validate using jpg|jpeg|png|doc|docx|pdf|xls|txt change this on validation function at the bottom

    private $Route = null; //If you have different route Name to Module name State it here |This wont be pluralized | set it null to use default

    private $New = '/* route for add new item form */'; //New User
    private $Save = ' route for save new item '; //Add New User
    private $Edit = ' route for update item '; //Update User

    private $ModuleName = 'main'; //Module Nmae

    /* Functions
    * -> __construct () = Load the most required operations E.g Class Module
    *
    */
    public function __construct()
    {

        //Libraries

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
    * Access Required pre-loaded data
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

        //Module Name - For Forms Title
        $data['ModuleName'] = $this->CoreForm->pluralize($this->ModuleName);
        $data['routeURL'] = (is_null($this->Route)) ? $this->CoreForm->pluralize($this->Folder) : $this->Route;

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
    public function pages($data,$layout='main')
    {
        //Chech allowed Access
        if ($this->CoreLoad->logged()) { //Authentication
            //Layout
            return view("admin/layouts/$layout",$data);
        }else{
            return $this->CoreLoad->notAllowed(); //Not Allowed To Access
        }
    }

    /*
    *
    * This is the first function to be accessed when a user open this controller
    * In here we can call the load function and pass data to passed as an array inorder to manupulate it inside passed function
    *   * Set your Page name/ID here N:B Page ID can be a number if you wish to access other values linked to the page opened E.g Meta Data
    *   * You can also set Page ID as actual pageName found in your view N:B do not put .php E.g home.php it should just be 'home'
    *   * Set Page template
    *   * Set Notification here
    *   By Default index does not allow notification Message to be passed, it uses the default message howevr you can pass using the notifyMessage variable
    *   However we advise to use custom notification message while opening index utilize another function called open
    *
    */
    public function index($notifyMessage=null)
    {

        //Model Query
        $data = $this->loadData('dashboard');
    
        //Notification
        $notify = $this->CoreNotify->notify();
        $data['notify'] = $this->CoreNotify->$notify($notifyMessage);

        //Open Page
        return $this->pages($data);
    }

    /*
    *
    * This is the function to be accessed when a user want to open specific page which deals with same controller E.g Edit data after saving
    * In here we can call the load function and pass data to passed as an array inorder to manupulate it inside passed function
    *   * Set your Page name/ID here N:B Page ID can be a number if you wish to access other values linked to the page opened E.g Meta Data
    *   * You can also set Page ID as actual pageName found in your view N:B do not put .php E.g home.php it should just be 'home'
    *   * Set Page template 
    *   * Set Notification here
    *   Custom notification message can be set/passed via $message
    *   PageName / ID can be passed via $pageID
    *   Page layout can be passed via $layout
    * 
    */
    public function open($pageID,$message=null,$layout='log')
    {

        //Pluralize Module

        //Model Query
        $data = $this->loadData($pageID);

        //Notification
        $notify = $this->CoreNotify->notify();
        $data['notify'] = $this->CoreNotify->$notify($message);

        //Open Page
        return $this->pages($data,$layout);
    }


}
