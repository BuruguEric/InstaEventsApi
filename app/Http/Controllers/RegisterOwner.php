<?php

namespace App\Http\Controllers;

use App\CoreCrud;
use App\CoreForm;
use App\CoreField;
use App\CoreLoad;
use App\CoreNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Rules\LognameCheck;
use App\Rules\ValidEmail;

class RegisterOwner extends Controller
{
    /*
    *
    * The main controller for Patient Registration
     *     * -> The controller require user to Register as Patient
    */
    private $CoreLoad;
    private $CoreForm;
    private $CoreField;
    private $CoreCrud;
    private $CoreNotify;

    private $Core = ''; //Core Lite Base Name | Change this if your Controller Name does not start with word Core
    private $Module = 'user'; //Module
    private $Folder = 'accounts'; //Set Default Folder For html files
    private $SubFolder = '/owner'; //Set Default Sub Folder For html files and Front End Use Start with /

    private $AllowedFile = null; //Set Default allowed file extension, remember you can pass this upon upload to override default allowed file type. Allowed File Extensions Separated by | also leave null to validate using jpg|jpeg|png|doc|docx|pdf|xls|txt change this on validation function at the bottom

    private $Route = null; //If you have different route Name to Module name State it here |This wont be pluralized | set it null to use default

    private $New = ''; //New User
    private $Save = 'owner-account/valid/register'; //Add New User
    private $Edit = ''; //Update User

    private $ModuleName = ''; //Module Nmae

    private $ValidEmail;
    private $LognameCheck;

    /* Functions
    * -> __construct () = Load the most required operations E.g Class Module
    *
    */
    public function __construct()
    {

        //Models
        $this->CoreLoad = new CoreLoad;
        $this->CoreForm = new CoreForm;
        $this->CoreField = new CoreField;
        $this->CoreCrud = new CoreCrud;
        $this->CoreNotify = new CoreNotify;

        //Helpers
        $this->ValidEmail = new ValidEmail;
        $this->LognameCheck = new LognameCheck;

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
        $data['Module'] = $this->CoreForm->pluralize($this->Folder);//Module Show
        $data['routeURL'] = (is_null($this->Route)) ? $this->CoreForm->pluralize($this->Folder) : $this->Route;

        //User Levels

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
    public function pages($data,$layout='main')
    {

        //Theme Name
        $theme_name = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'theme_name','flg'=>1));

        //Check if site is online
        if ($this->CoreLoad->site_status() == TRUE) {
            //Layout
            return view("themes/$theme_name/layouts/$layout",$data);
        }else{
            $this->CoreLoad->siteOffline(); //Site is offline
        }
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
        //Model Query
        $data = $this->loadData($this->CoreForm->pluralize($this->Folder).$this->SubFolder."/register");

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
    public function open($pageID,$message=null,$layout='main')
    {

        //Pluralize Module

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
        $coreModule = ucwords($this->Core).ucwords($module);
        $routeURL = (is_null($this->Route)) ? $module : $this->Route;
        $baseLoadPath = $this->CoreForm->pluralize($this->Folder).$this->SubFolder.'/';

        //Set Allowed Files
        $allowed_files = (is_null($this->AllowedFile))? 'jpg|jpeg|png|doc|docx|pdf|xls|txt' : $this->AllowedFile;

        //Check Validation
        if ($type == 'register') {

            $formData = $this->CoreLoad->input(); //Input Data

            //Form Validation Values
            $validatedData = Validator::make($formData,[
                'name' => ['required','min:1','max:100'],
                'email' => ['required','min:1','max:100','email','unique:users,user_email',$this->ValidEmail],
                'mobile' => ['required','min:1','unique:users,user_logname'],
                'password' => ['required','min:4|confirmed'],
                'gender' => ['required','min:1']
            ])->validate();;

            //Form Validation
            if ($validatedData == TRUE) {

                $formData['user_name'] = $formData['name'];
                $formData['user_level'] = 'owner';
                $formData['user_logname'] = $formData['mobile'];
                $formData['user_email'] = $formData['email'];
                $formData['user_password'] = $formData['password'];
                $formData['user_mobile'] = $formData['mobile'];
                $formData['gender'] = $formData['gender'];

                //Generate OTP COde
                $otp_code = "TB".$this->CoreLoad->random(4,'0123456789');
                $formData['user_default'] = $otp_code;
                $formData['user_flg'] = 0;

                //UnsetData
                $unsetData = array('user_mobile','gender','name','mobile','email','password','password_confirmation','confirm_password');

                if ($this->create($formData,$unsetData)) {
                    session()->flash('notification','success'); //Notification Type

                    //OTP Session Logname
                    $session_otp = $this->CoreForm->sessionName('otp');
                    $logname = session()->get("$session_otp");
                    $otp_code = $this->CoreCrud->selectSingleValue('user','default',array('logname'=>$logname));

                    //Send SMS
                    $dial_code = $this->CoreField->sendOTP($logname,$otp_code);
                    return redirect('otp-verification');//Redirect to Page
                }else{
                    session()->flash('notification','error'); //Notification Type
                    return $this->open('register');//Open Page
                }
            }else{
                session()->flash('notification','error'); //Notification Type
                $message = 'Please check the fields, and try again'; //Notification Message
                return $this->open('register',$message);//Open Page
            }
        }
        elseif ($type == 'app') {
            
            $appData = $this->CoreLoad->input(); //Input Data

            //Check Data
            $column_details = strtolower($this->CoreForm->get_column_name($this->Module,'details'));
            $formData = (array_key_exists($column_details,$appData))? json_decode(stripcslashes($appData[$column_details]),True) : $appData;

            //Extra Data
            $formData['user_level'] = 'owner';
            $unsetData = array('user_phone');

            if ($this->create($formData,$unsetData)) {

                $newid = session()->get('newid');
                $apiStatus = json_encode(array('status'=>true,'user_id'=>$newid));
                echo $apiStatus;
            }else{
                $apiStatus = json_encode(array('status'=>false));
                echo $apiStatus;
            }
        }
        else{
            session()->flash('notification','notify'); //Notification Type
            return $this->index(); //Index Page
        }
    }

    /*
    * The function is used to save/insert data into table
    * First is the data to be inserted
    *  N:B the data needed to be in an associative array form E.g $data = array('name' => 'theName');
    *      the array key will be used as column name and the value as inputted Data
    *  For colum default/details convert data to JSON on valid() method level
    *
    * Second is the data to be unset | Unset is to be used if some of the input you wish to be removed
    *
    */
    public function create($insertData,$unsetData=null)
    {

        //Pluralize Module
        $tableName = $this->CoreForm->pluralize($this->Module);

        //Column Stamp
        $stamp = strtolower($this->CoreForm->get_column_name($this->Module,'stamp'));
        $insertData[$stamp] = date('Y-m-d H:i:s',time());
        //Column Flg
        // $flg = strtolower($this->CoreForm->get_column_name($this->Module,'flg'));
        // $insertData[$flg] = 1;

        //Column Password
        $column_password = strtolower($this->CoreForm->get_column_name($this->Module,'password'));

        //Check IF there is Password
        if (array_key_exists($column_password,$insertData)) {
            $hased_password = sha1(strtotime($insertData[$stamp]).$insertData[$column_password]);//Hashed Password
            $hased_bcrypt = trim($hased_password);//Bycrypt Password
            $insertData[$column_password] = $hased_bcrypt;
        }

        $details = strtolower($this->CoreForm->get_column_name($this->Module,'details'));
        $insertData[$details] = json_encode($insertData);

        $insertData = $this->CoreCrud->unsetData($insertData,$unsetData); //Unset Data

        //Insert Data Into Table
        $query = DB::table($tableName)->insert($insertData);
        if ($query) {

            $logname = strtolower($this->CoreForm->get_column_name($this->Module,'logname')); //Logname
            $user_logname = $insertData[$logname];  //Logname

            $this->CoreField->setOtpSession($user_logname);

            $id = DB::getPdo()->lastInsertId();//Get Last Insert ID
            session()->put('newid',$id); //Create Session

            return true; //Data Inserted
        }else{

            return false; //Data Insert Failed
        }
    }
}

