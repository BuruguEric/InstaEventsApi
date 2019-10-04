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

class CoreSettings extends Controller
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
    private $Module = 'setting'; //Module
    private $Folder = 'setting'; //Set Default Folder For html files
    private $SubFolder = ''; //Set Default Sub Folder For html files and Front End Use Start with /

    private $AllowedFile = null; //Set Default allowed file extension, remember you can pass this upon upload to override default allowed file type. Allowed File Extensions Separated by | also leave null to validate using jpg|jpeg|png|doc|docx|pdf|xls|txt change this on validation function at the bottom

    private $Route = null; //If you have different route Name to Module name State it here |This wont be pluralized | set it null to use default

	private $General = 'settings/valid/general'; //Settings
	private $Link = 'settings/valid/link'; //
	private $Mail = 'settings/valid/mail'; //
	private $Blog = 'settings/valid/blog'; //
	private $Seo = 'settings/valid/seo'; //
	private $Inheritance = 'settings/valid/inheritance'; //
	private $Modulelist = 'settings/valid/module'; //

	private $ModuleName = 'settings'; //Module Nmae

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
        $data['Module'] = $this->CoreForm->pluralize($this->Folder);//Module Show
        $data['routeURL'] = (is_null($this->Route)) ? $this->CoreForm->pluralize($this->Folder) : $this->Route;

		//Module Name - For Forms Title
		$data['ModuleName'] = $this->CoreForm->pluralize($this->ModuleName);

		//Post
		$data['posts'] = $this->CoreCrud->selectMultipleValue('pages','id,title',array('flg'=>1));

		//Form Submit URLs
		$data['form_general'] = $this->General;
		$data['form_link'] = $this->Link;
		$data['form_mail'] = $this->Mail;
		$data['form_blog'] = $this->Blog;
		$data['form_seo'] = $this->Seo;
		$data['form_inheritance'] = $this->Inheritance;
		$data['form_module'] = $this->Modulelist;

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
        if ($this->CoreLoad->auth($this->Module)) { //Authentication
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

        //Model Query

        //Table Select & Clause

        //Notification

        //Open Page
        return $this->open('general');
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
		$module = $this->CoreForm->pluralize($this->Module);

		//Model Query
		$pageID = (is_numeric($pageID)) ? $pageID : $this->CoreForm->pluralize($this->Folder).$this->SubFolder."/".$pageID;
		$data = $this->loadData($pageID);

		//Data
		$data['resultList'] = $this->load_settings($pageID);

		//Notification
		$notify = $this->CoreNotify->notify();

		// echo $notify;
		// echo "<br /> $message";
		// die;
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

		//Set Allowed Files
		$allowed_files = (is_null($this->AllowedFile))? 'jpg|jpeg|png|doc|docx|pdf|xls|txt' : $this->AllowedFile;

		//Check Validation
		if ($type == 'general') {

			$updateData = $this->CoreLoad->input(); //Input Data

            $validatedData = Validator::make($updateData,[
                'site_title' => ['required','min:1','max:800'],
                'site_slogan' => ['required','min:1','max:800'],
                'site_status' => ['required','min:1','max:10'],
            ])->validate();;

			//Form Validation
			if ($validatedData == TRUE) {
				if ($this->update($updateData)) {
                    session()->flash('notification','success'); //Notification Type
					return $this->open($type);//Redirect to Page
				}else{
                    session()->flash('notification','error'); //Notification Type
					return $this->open($type);//Open Page
				}
			}else{
                session()->flash('notification','error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				return $this->open($type,$message);//Open Page
			}			
		}
		elseif ($type == 'link') {

			$updateData = $this->CoreLoad->input(); //Input Data

            $validatedData = Validator::make($updateData,[
                'current_url' => ['required','min:1','max:50'],
            ])->validate();;

			//Form Validation
			if ($validatedData == TRUE) {
				if ($this->update($updateData)) {

					//Update Blog URL
            		$postData = DB::table('blogs')->select('blog_id')->get();

					if (count($postData) > 0) {
						foreach ($postData as $row) {
							$post_id = $row->blog_id; //Post ID
							$url = $this->CoreCrud->postURL($post_id,null,'blog');
							DB::update("UPDATE blogs SET blog_url = '$url' WHERE blog_id = ?", [$post_id]);
						}
					}

					//Update POST URL
            		$postData = DB::table('pages')->select('page_id')->get();

					if (count($postData) > 0) {
						foreach ($postData as $row) {
							$post_id = $row->page_id; //Post ID
							$url = $this->CoreCrud->postURL($post_id);
							DB::update("UPDATE pages SET page_url = '$url' WHERE page_id = ?", [$post_id]);
						}
					}

					session()->flash('notification','success'); //Notification Type
					return $this->open($type);//Redirect to Page
				}else{
					session()->flash('notification','error'); //Notification Type
					return $this->open($type);//Open Page
				}
			}else{
				session()->flash('notification','error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				return $this->open($type,$message);//Open Page
			}			
		}elseif ($type == 'mail') {

			$updateData = $this->CoreLoad->input(); //Input Data

            $validatedData = Validator::make($updateData,[
                'mail_protocol' => ['required','min:1','max:50'],
                'smtp_host' => ['required','min:1','max:50'],
                'smtp_user' => ['required','min:1','max:50'],
                'smtp_pass' => ['required','min:1','max:50'],
                'smtp_port' => ['required','min:1','max:50'],
                'smtp_timeout' => ['required','min:1','max:50'],
                'smtp_crypto' => ['required','min:1','max:50'],
                'wordwrap' => ['required','min:1','max:50'],
                'wrapchars' => ['required','min:1','max:50'],
                'mailtype' => ['required','min:1','max:50'],
                'charset' => ['required','min:1','max:50'],
            ])->validate();;

			//Form Validation
			if ($validatedData == TRUE) {
				if ($this->update($updateData)) {
					session()->flash('notification','success'); //Notification Type
					return $this->open($type);//Redirect to Page
				}else{
					session()->flash('notification','error'); //Notification Type
					return $this->open($type);//Open Page
				}
			}else{
				session()->flash('notification','error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				return $this->open($type,$message);//Open Page
			}			
		}elseif ($type == 'blog') {

			$updateData = $this->CoreLoad->input(); //Input Data

            $validatedData = Validator::make($updateData,[
                'home_display' => ['required','min:1','max:50'],
                'home_post' => ['required','min:1','max:50'],
                'home_page' => ['required','min:1','max:50'],
                'post_per_page' => ['required','min:1','max:50','integer'],
                'post_show' => ['required','min:1','max:50'],
            ])->validate();;

			//Form Validation
			if ($validatedData == TRUE) {
				if ($this->update($updateData)) {
					session()->flash('notification','success'); //Notification Type
					return $this->open($type);//Redirect to Page
				}else{
					session()->flash('notification','error'); //Notification Type
					return $this->open($type);//Open Page
				}
			}else{
				session()->flash('notification','error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				return $this->open($type,$message);//Open Page
			}
		}elseif ($type == 'seo') {

			$updateData = $this->CoreLoad->input(); //Input Data

            $validatedData = Validator::make($updateData,[
                'seo_visibility' => ['required','min:1','max:50'],
                'seo_global' => ['required','min:1','max:50'],
                'seo_description' => ['required','max:8000'],
                'seo_keywords' => ['required','max:8000'],
            ])->validate();;

			//Form Validation
			if ($validatedData == TRUE) {
				if ($this->update($updateData)) {
					session()->flash('notification','success'); //Notification Type
					return $this->open($type);//Redirect to Page
				}else{
					session()->flash('notification','error'); //Notification Type
					return $this->open($type);//Open Page
				}
			}else{
				session()->flash('notification','error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				return $this->open($type,$message);//Open Page
			}
		}elseif ($type == 'inheritance') {

			$updateData = $this->CoreLoad->input(); //Input Data

            $validatedData = Validator::make($updateData,[
                'inheritance_data' => ['required'],
            ])->validate();;

			//Form Validation
			if ($validatedData == TRUE) {
				if ($this->update($updateData)) {
					session()->flash('notification','success'); //Notification Type
					return $this->open($type);//Redirect to Page
				}else{
					session()->flash('notification','error'); //Notification Type
					return $this->open($type);//Open Page
				}
			}else{
				session()->flash('notification','error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				return $this->open($type,$message);//Open Page
			}
		}elseif ($type == 'module') {

			$updateData = $this->CoreLoad->input(); //Input Data

            $validatedData = Validator::make($updateData,[
                'module_list' => ['required'],
            ])->validate();;

			//Form Validation
			if ($validatedData == TRUE) {
				if ($this->update($updateData)) {
					session()->flash('notification','success'); //Notification Type
					return $this->open($type);//Redirect to Page
				}else{
					session()->flash('notification','error'); //Notification Type
					return $this->open($type);//Open Page
				}
			}else{
				session()->flash('notification','error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				return $this->open($type,$message);//Open Page
			}
		}else{
			session()->flash('notification','notify'); //Notification Type
			$this->index(); //Redirect Index Module
		}
	}

	/*
	* The function is used to update data in the table
	* First parameter is the data to be updated 
	*  N:B the data needed to be in an associative array form E.g $data = array('name' => 'theName');
	*      the array key will be used as column name and the value as inputted Data
	* 
	*/
	public function update($updateData)
	{

    	//Chech allowed Access
		if ($this->CoreLoad->auth($this->Module)) { //Authentication

			//Pluralize Module
			$tableName = $this->CoreForm->pluralize($this->Module);
			$x = 0;

			//Update Data In The Table
			foreach ($updateData as $key => $value) {
			    $valueWhere = array('setting_title' =>$key);
			    $updateData = array('setting_value' =>$value);
            	$results = DB::table($tableName)->where($valueWhere)->update($updateData);

            	$result[$x] = (!empty($results))? true : false; //Check Results
            	$x++;
			}


			// Check Status
			if (in_array(true,$result)) {
				return true; //Data Updated
			}else{

				return false; //Data Updated Failed
			}
		}
	}

	/*
	*
	* Check Which Settings Type To Open
	* Pass the Page Name
	*/
	public function load_settings($page_name)
	{
		//Set Condition
		$where = array('setting_flg' =>1);
		$page = explode('/',$page_name);

		if (end($page) == 'general') {
			$where_in = array('site_title','site_slogan','site_status','offline_message');//General Update
		}elseif (end($page) == 'link') {
			$where_in = array('current_url');//General Update
		}elseif (end($page) == 'mail') {
			$where_in = array('mail_protocol','smtp_host','smtp_user','smtp_pass','smtp_port','smtp_timeout','smtp_crypto',
			'wordwrap','wrapchars','mailtype','charset');//General Update
		}elseif (end($page) == 'blog') {
			$where_in = array('home_display','home_post','home_page','post_per_page','post_show');//General Update
		}elseif (end($page) == 'seo') {
			$where_in = array('seo_visibility','seo_keywords','seo_description ','seo_global','seo_meta_data');//General Update
		}elseif (end($page) == 'inheritance') {
			$where_in = array('inheritance_data');//Inheritance Data
		}elseif (end($page) == 'module') {
			$where_in = array('module_list');//Inheritance Data
		}else{
			$where_in = array('none');//General Update
		}

		//Search Data
        $resultList = DB::table('settings')->select('setting_title','setting_value')->whereIn('setting_title',$where_in)->get();

		//Data Returned
		return $resultList;
	}

}
