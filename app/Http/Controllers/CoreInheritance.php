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

class CoreInheritance extends Controller
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
    private $Module = 'inheritance'; //Module
    private $Folder = 'configs'; //Set Default Folder For html files
    private $SubFolder = '/inheritance'; //Set Default Sub Folder For html files and Front End Use Start with /

    private $AllowedFile = null; //Set Default allowed file extension, remember you can pass this upon upload to override default allowed file type. Allowed File Extensions Separated by | also leave null to validate using jpg|jpeg|png|doc|docx|pdf|xls|txt change this on validation function at the bottom

    private $Route = 'inheritances'; //If you have different route Name to Module name State it here |This wont be pluralized | set it null to use default

    private $New = 'inheritances/open/add'; //New User
    private $Save = 'inheritances/valid/save'; //Add New User
    private $Edit = 'inheritances/valid/update'; //Update User

    private $ModuleName = 'inheritances'; //Module Nmae
    private $ValidEmail =''; //Valid Email
    private $LognameCheck =''; //Check LogName

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

	    //Select Inheritance
		$inheritance_type = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'inheritance_data','flg'=>1));

		$data['inheritance_type'] = explode(',', $inheritance_type);
	    $data['inheritance_parent'] = $this->CoreCrud->selectInheritanceItem(array('flg'=>1),'id,type,parent,title');

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
        $module = $this->CoreForm->pluralize($this->Module);

        //Model Query
        $data = $this->loadData($this->CoreForm->pluralize($this->Folder).$this->SubFolder."/list");

        //Table Select & Clause
	   	$columns = array('id,title as title,type as type,flg as status');
	   	$where = null;
        $data['dataList'] = $this->CoreCrud->selectCRUD($module,$where,$columns);

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
	*  This function is to be called when you want to pass the Edit form
    * In here we can call the load function and pass data to passed as an array inorder to manupulate it inside passed function
    * 	* Set your Page name/ID here N:B Page ID can be a number if you wish to access other values linked to the page opened E.g Meta Data
    * 	* You can also set Page ID as actual pageName found in your view N:B do not put .php E.g home.php it should just be 'home'
    * 	* Set Page template 
    * 	* Set Notification here
    * 	Custom notification message can be set/passed via $message
    * 	PageName / ID can be passed via $pageID
    * 	Page layout can be passed via $layout
    *
    * 	For inputTYPE and inputID
    *
    * 	--> inputTYPE
    * 	  This is the name of the column you wish to select, most of the time is coumn name 
    * 	  Remember to Pass ID or Pass data via GET request using variable inputTYPE 
    * 	  
    * 	--> inputID
    * 	  This is the value of the column you wish to match
    * 	  Remember to Pass Value or Pass data via GET request using variable inputID 
    *
    *  If either inputTYPE or inputID is not passed error message will be generated
	* 
	*/
	public function edit($pageID,$inputTYPE='id',$inputID=null,$message=null,$layout='main')
	{
		//Pluralize Module
		$module = $this->CoreForm->pluralize($this->Module);

		//Model Query
		$pageID = (is_numeric($pageID)) ? $pageID : $this->CoreForm->pluralize($this->Folder).$this->SubFolder."/".$pageID;
		$data = $this->loadData($pageID);

		$inputTYPE = (is_null($inputTYPE)) ? $this->CoreLoad->input('inputTYPE','GET') : $inputTYPE; //Access Value
		$inputID = (is_null($inputID)) ? $this->CoreLoad->input('inputID','GET') : $inputID; //Access Value

		if (!is_null($inputTYPE) || !is_null($inputID)) {
			//Table Select & Clause
			$where = array($inputTYPE =>$inputID);
	   		$columns = array('id as id,type as type,title as title,parent as parent,title as title');
			$data['resultList'] = $this->CoreCrud->selectCRUD($module,$where,$columns);

			//Notification
			$notify = $this->CoreNotify->notify();
			$data['notify'] = $this->CoreNotify->$notify($message);

			//Open Page
			return $this->pages($data,$layout);
		}else{

			//Notification
            session()->flash('notification','error');

			//Error Edit | Load the Manage Page
			return $this->open('list',$message='System could not find the detail ID');
		}
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
        if ($type == 'save') {

            $formData = $this->CoreLoad->input(); //Input Data
            
            //Form Validation Values
            $validatedData = Validator::make($formData,[
                'inheritance_type' => ['required','min:1','max:200'],
                'inheritance_parent' => ['required','min:1','max:100'],
                'inheritance_title' => ['required','min:1','max:5000'],
            ])->validate();;

            //Form Validation
            if ($validatedData == TRUE) {
                if ($this->create($formData)) {
                    session()->flash('notification','success'); //Notification Type
                    return redirect($this->New);//Redirect to Page
                }else{
                    session()->flash('notification','error'); //Notification Type
                    return $this->open('add');//Open Page
                }
            }else{
                session()->flash('notification','error'); //Notification Type
                $message = 'Please check the fields, and try again'; //Notification Message
                return $this->open('add',$message);//Open Page
            }
        }
        elseif ($type == 'bulk') {

            $action = Input::get('action'); //Get Action
            $selectedData = json_decode(Input::get('inputID'), true); //Get Selected Data
            $column_id = strtolower($this->CoreForm->get_column_name($this->Module,'id')); //column name Reference column
            $column_flg = strtolower($this->CoreForm->get_column_name($this->Module,'flg')); //Column name of Updated Input

            //Check If Selection has Value
            if (!empty($selectedData)) {
                //Check Action
                if (strtolower($action) == 'edit') {
                    session()->flash('notification','notify'); //Notification Type
                    return $this->edit('edit','id',$selectedData[0]);//Open Page
                }else{
                    for($i = 0; $i < count($selectedData); $i++){ //Loop through all submitted elements
                        $value_id = $selectedData[$i]; //Select Value To Update with
                        if (strtolower($action) == 'activate') { //Item/Data Activation
                            $this->update(array($column_flg =>1),array($column_id =>$value_id)); //Call Update Function
                        }elseif (strtolower($action) == 'deactivate'){ //Item/Data Deactivation
                            $this->update(array($column_flg =>0),array($column_id =>$value_id)); //Call Update Function
                        }elseif (strtolower($action) == 'delete'){ //Item/Data Deletion
                            $this->delete(array($column_id => $value_id)); //Call Delete Function
                        }else{
                            session()->flash('notification','error'); //Notification Type
                            $message = 'Wrong data sequence received'; //Notification Message
                            return $this->index($message);//Open Page
                        }
                    }
                    session()->flash('notification','success'); //Notification Type
                    return redirect($routeURL); //Redirect Index Module
                }
            }else{
                session()->flash('notification','error'); //Notification Type
                $message = 'Please make a selection first, and try again'; //Notification Message
                return $this->index($message);//Open Page
            }
        }
        elseif ($type == 'update') {

            $updateData = $this->CoreLoad->input(); //Input Data
            $column_password = strtolower($this->CoreForm->get_column_name($this->Module,'password'));//Column Password
            $column_id = strtolower($this->CoreForm->get_column_name($this->Module,'id'));//Column ID
            $value_id = $this->CoreLoad->input('id'); //Input Value

            //Form Validation Values
            $validatedData = Validator::make($updateData,[
                'inheritance_type' => ['required','min:1','max:200'],
                'inheritance_parent' => ['required','min:1','max:100'],
                'inheritance_title' => ['required','min:1','max:5000'],
            ])->validate();;

			$column_id = strtolower($this->CoreForm->get_column_name($this->Module,'id'));//Column ID
			$value_id = Input::post('id'); //Input Value

			//Select Value To Unset 
			$unsetData = array('id');/*valude To Unset*/

            //Form Validation
            if ($validatedData == TRUE) {

                //Update Table
                if ($this->update($updateData,array($column_id =>$value_id),$unsetData)) {
                    session()->flash('notification','success'); //Notification Type
                    $message = 'Data was updated successful'; //Notification Message
                    return $this->edit('edit','id',$value_id);//Open Page
                }else{
                    session()->flash('notification','error'); //Notification Type
                    return $this->edit('edit','id',$value_id);//Open Page
                }
            }else{
                session()->flash('notification','error'); //Notification Type
                $message = 'Please check the fields, and try again'; //Notification Message
                return $this->edit('edit','id',$value_id,$message);//Open Page
            }
        }
        elseif ($type == 'delete') {
            $value_id = Input::get('inputID'); //Get Selected Data
            $column_id = strtolower($this->CoreForm->get_column_name($this->Module,'id'));

            if ($this->delete(array($column_id => $value_id)) == TRUE) { //Call Delete Function
                session()->flash('notification','success'); //Notification Type
                return redirect($routeURL); //Redirect Index Module
            }else{
                session()->flash('notification','error'); //Notification Type
                return redirect($routeURL); //Redirect Index Module
            }
        }
        else{

            session()->flash('notification','notify'); //Notification Type
            return redirect($routeURL); //Redirect Index Module
        }
    }

    /*
    * The function is used to save/insert data into table
    * First is the data to be inserted
    *  N:B the data needed to be in an associative array form E.g $data = array('name' => 'theName');
    *      the array key will be used as column name and the value as inputted Data
    *  For colum default/details convert data to JSON on valid() method level
    *
    * Third is the data to be unset | Unset is to be used if some of the input you wish to be removed
    *
    */
    public function create($insertData,$unsetData=null)
    {

        //Chech allowed Access
        if ($this->CoreLoad->auth($this->Module)) { //Authentication

            //Pluralize Module
            $tableName = $this->CoreForm->pluralize($this->Module);

            //Column Stamp
            $stamp = strtolower($this->CoreForm->get_column_name($this->Module,'stamp'));
            $insertData[$stamp] = date('Y-m-d H:i:s',time());
            //Column Flg
            $flg = strtolower($this->CoreForm->get_column_name($this->Module,'flg'));
            $insertData[$flg] = 1;

            $insertData = $this->CoreCrud->unsetData($insertData,$unsetData); //Unset Data

            $details = strtolower($this->CoreForm->get_column_name($this->Module,'details'));
            $insertData[$details] = json_encode($insertData);

            //Insert Data Into Table
            $query = DB::table($tableName)->insert($insertData);
            ///$id = DB::getPdo()->lastInsertId(); -> Get Last Insert ID
            if ($query) {

                return true; //Data Inserted
            }else{

                return false; //Data Insert Failed
            }
        }else{
            return $this->CoreLoad->notAllowed(); //Not Allowed To Access
        }
    }

    /*
    * The function is used to update data in the table
    * First parameter is the data to be updated
    *  N:B the data needed to be in an associative array form E.g $data = array('name' => 'theName');
    *      the array key will be used as column name and the value as inputted Data
    *  For colum default/details convert data to JSON on valid() method level
    * Third is the values to be passed in where clause N:B the data needed to be in an associative array form E.g $data = array('column' => 'value');
    * Fourth is the data to be unset | Unset is to be used if some of the input you wish to be removed
    *
    */
    public function update($updateData,$valueWhere,$unsetData=null)
    {

        //Chech allowed Access
        if ($this->CoreLoad->auth($this->Module)) { //Authentication

			//Pluralize Module
			$tableName = $this->CoreForm->pluralize($this->Module);

			//Column Stamp
			$stamp = $this->CoreForm->get_column_name($this->Module,'stamp');
			$updateData["$stamp"] = date('Y-m-d H:i:s',time());

			//Update
			$updateData = $this->CoreCrud->unsetData($updateData,$unsetData); //Unset Data

			//Details Column Update
			$details = strtolower($this->CoreForm->get_column_name($this->Module,'details'));
            foreach ($valueWhere as $key => $value) {	$whereData = array($key => $value); /* Where Clause */ 	}
            $current_details = json_decode(DB::table($tableName)->where($whereData)->limit(1)->value($details), true);

			foreach ($updateData as $key => $value) { $current_details["$key"] = $value; /* Update -> Details */ }
			$updateData["$details"] = json_encode($current_details);

            //Update Data In The Table
            $query = DB::table($tableName)->where($valueWhere)->update($updateData);
            if ($query) {

                return true; //Data Updated
            }else{

                return false; //Data Updated Failed
            }
        }else{
            return $this->CoreLoad->notAllowed(); //Not Allowed To Access
        }
    }

    /*
    * The function is used to delete data in the table
    * First parameter is the values to be passed in where clause N:B the data needed to be in an associative array form E.g $data = array('column' => 'value');
    *
    */
    public function delete($valueWhere)
    {

        //Chech allowed Access
        if ($this->CoreLoad->auth($this->Module)) { //Authentication

            //Pluralize Module
            $tableName = $this->CoreForm->pluralize($this->Module);

            //Deleted Data In The Table
            $query = DB::table($tableName)->where($valueWhere)->delete();
            if ($query) {

                return true; //Data Deleted
            }else{

                return false; //Data Deletion Failed
            }
        }else{
            return $this->CoreLoad->notAllowed(); //Not Allowed To Access
        }
    }
}
