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


class CoreLogs extends Controller
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
    private $Module = 'user'; //Module
    private $Folder = '/* HTML Source Folder Name */'; //Set Default Folder For html files
    private $SubFolder = ''; //Set Default Sub Folder For html files and Front End Use Start withphp /

    private $AllowedFile = null; //Set Default allowed file extension, remember you can pass this upon upload to override default allowed file type. Allowed File Extensions Separated by | also leave null to validate using jpg|jpeg|png|doc|docx|pdf|xls|txt change this on validation function at the bottom

    private $Route = null; //If you have different route Name to Module name State it here |This wont be pluralized | set it null to use default

	private $New = 'admin/login'; //New Login
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
		$data['Module'] = $this->CoreForm->pluralize($this->Module);//Module Show
		$data['routeURL'] = (is_null($this->Route)) ? $this->CoreForm->pluralize($this->Folder) : $this->Route;

		//Module Name - For Forms Title
		$data['ModuleName'] = $this->CoreForm->pluralize($this->ModuleName);

		//Form Submit URLs
		$data['form_new'] = $this->New;
		$data['form_save'] = $this->Save;
		$data['form_edit'] = $this->Edit;

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
    public function pages($data,$layout='log')
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
	public function index($notifyMessage=null)
	{
		//Pluralize Module
		$module = $this->CoreForm->pluralize($this->Module);

		//Model Query
		$data = $this->loadData("login");

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
    * 	* Set your Page name/ID here N:B Page ID can be a number if you wish to access other values linked to the page opened E.g Meta Data
    * 	* You can also set Page ID as actual pageName found in your view N:B do not put .php E.g home.php it should just be 'home'
    * 	* Set Page template 
    * 	* Set Notification here
    * 	Custom notification message can be set/passed via $message
    * 	PageName / ID can be passed via $pageID
    * 	Page layout can be passed via $layout
	* 
    */
	public function open($pageID,$message=null,$layout='log')
	{

		//Pluralize Module
		$module = $this->CoreForm->pluralize($this->Module);

		//Model Query
		$pageID = (is_numeric($pageID)) ? $pageID : $this->CoreForm->pluralize($this->Folder).$this->SubFolder."/".$pageID;
		$data = $this->loadData($pageID);

		//Notification
		$notify = $this->CoreNotify->notify();
		$data['notify'] = $this->CoreNotify->$notify($message);

		//Open Page
		return $this->pages($data,$layout);
	}

	/*
	*
	* Module form values are validated here
	* The function accept variable TYPE which is used to know which form element to validate by changing the validation methods
	* All input related to this Module or controller should be validated here and passed to Create/Update/Delete
	*
	* Reidrect Main : Main is the controller which is acting as the default Controller (read more on codeigniter manual : route section) | inshort it will load 
	* 				 first and most used to display the site/system home page
	* 
	*/
    public function valid($type)
	{

		//Pluralize Module
		$module = $this->CoreForm->pluralize($this->Module);
		$routeURL = (is_null($this->Route)) ? $module : $this->Route;

		//Set Allowed Files
		$allowed_files = (is_null($this->AllowedFile))? 'jpg|jpeg|png|doc|docx|pdf|xls|txt' : $this->AllowedFile;

		//Check Validation
		if ($type == 'login') {

			$formData = $this->CoreLoad->input(); //Input Data
           
            //Form Validation Values
            $validatedData = Validator::make($formData,[
                'user_logname' => ['required','min:1'],
                'user_password' => ['min:1'],
            ])->validate();;

			//Form Validation
			if ($validatedData == TRUE) {
				if ($this->login($formData) == 'success') {
					session()->flash('notification','notify'); //Notification Type
					return redirect("dashboard");//Redirect to Page
				}elseif ($this->login($formData) == 'wrong') {
					session()->flash('notification','error'); //Notification Type
					$message = 'Failed!, wrong password or username'; //Notification Message				
					return $this->index($message);//Open Page
				}elseif ($this->login($formData) == 'deactivated') {
					session()->flash('notification','error'); //Notification Type
					$message = 'Failed!, your account is suspended'; //Notification Message				
					return $this->index($message);//Open Page
				}
				else{
					session()->flash('notification','error'); //Notification Type
					$message = 'Failed!, account does not exist'; //Notification Message				
					return $this->index($message);//Open Page
				}
			}else{

				session()->flash('notification','error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				return $this->index($message);//Open Page
			}			
		}elseif ($type == 'reset') {
			session()->flash('notification','error'); //Notification Type
			$message = 'Sorry!, reset password will be available later'; //Notification Message				
			return $this->index($message);//Open Page
		}
		elseif ($type == 'logout') {
			session()->flush();//User Logout
			return $this->index();//Open Page
		}
        else{
			session()->flash('notification','notify'); //Notification Type
			return $this->index();//Open Page
		}
	}

    /*
    *
    * Fuction for Login Validation
    * The fuction takes, accept form data which passed through CoreLoad Input
    * 
    */
    public function login($formData)
    {
        //Pluralize Module
        $tableName = $this->CoreForm->pluralize($this->Module);
        $column_logname = $this->CoreForm->get_column_name($this->Module,'logname'); //Logname Column
        $column_password = $this->CoreForm->get_column_name($this->Module,'password'); //Password Column
        $column_stamp = $this->CoreForm->get_column_name($this->Module,'stamp'); //Stamp Column
        $column_level = $this->CoreForm->get_column_name($this->Module,'level'); //Stamp Level
        $column_flg = $this->CoreForm->get_column_name($this->Module,'flg'); //Stamp FLG
        $column_id = $this->CoreForm->get_column_name($this->Module,'id'); //Stamp ID

        //Get Array Data
        foreach ($formData as $key => $value) {
            if (strtolower($key) == $column_logname) {
                $logname = $value; //Set user logname
            }else{
                $password = $value; //Set user Password
            }
        }

        //Get Date Time
        $result = DB::table($tableName)->select($column_stamp)->where($column_logname,$logname)->limit(1)->get();
        if (count($result) === 1) {

            $stamp = $result[0]->$column_stamp; //Date Time

            //Check If Enabled            
            if (DB::table($tableName)->where($column_logname,$logname)->limit(1)->value($column_flg)) {         
                $hased_password = sha1(strtotime($stamp).$password);//Hashed Password
                $hased_bcrypt = trim($hased_password);//Bycrypt Password

                $where = array($column_logname =>$logname, $column_password =>$hased_bcrypt); // Where Clause

                $query = DB::table($tableName)
                ->select($column_id,$column_level)->where($where)->limit(1)->get(); //Set Query Select

                if (count($query) === 1) {                           
                    $newsession = array('id'=>$query[0]->$column_id,'level'=>$query[0]->$column_level,'logged'=>TRUE); //Set Session Data

                    $session_id = $this->CoreForm->sessionName('id');
                    $session_level = $this->CoreForm->sessionName('level');
                    $session_logged = $this->CoreForm->sessionName('logged');

                    session()->put($session_id,$query[0]->$column_id); //Create Session
                    session()->put($session_level,$query[0]->$column_level); //Create Session
                    session()->put($session_logged,TRUE); //Create Session

                    return 'success'; //Logged In
                }else{
                    return 'wrong'; //Wrong Account Password / Logname
                }
            }else{
                return 'deactivated'; //Account Deactivated
            }
        }else{
            return 'error'; //Account Don't Exist
        }
    }


}
