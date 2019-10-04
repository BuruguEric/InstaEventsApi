<?php

namespace App;


use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CoreForm extends Model
{


    /*
    *
    * The function generate proper multiple/single column names
    * The function accepts
    * 1: Module Name
    * 2: Column simple name(s)
    *
    */
    public function get_column_name($module,$column)
    {
        //Singularize Module
        $module = $this->singularize($module);

        if (!is_array($column) && strpos($column,",") == False) {
            $column_name = $module.'_'.$column; //Column Name
        }else{
            if (!is_array($column) && strpos($column,",") == True) { $column = explode(",", $column); /* Get Column Name */ }
            for($i = 0; $i < count($column); $i++){
                $column_name[$i] = $this->get_column_name($module,$column[$i]); //Column Name
            }
        }

        return $column_name; //Column Name
    }

    /*
    *
    * Function to remove column Name and Return Label Name
    * Pass columns name(s) array/string
    *
    */
    public function get_label_name($column)
    {
        //Check If Value Passed is Not Array
        if (!is_array($column) && strpos($column,",") == False) {
            $label =  substr($column,strpos($column, "_") +1); //Get Current Label Name
        }else{
            if (!is_array($column) && strpos($column,",") == True) { $column = explode(",", $column); /* Get Column Name */ }
            //Remove Module Name
            for($i = 0; $i < count($column); $i++){
                $column_name = $column[$i]; //Set Current Column Name
                $label[$i] =  substr($column_name,strpos($column_name, "_") +1); //Get Current Label Name
            }
        }

        return $label;//Return Label List
    }

    /*
    *
    * Function to remove column Name and Return Column Label Name
    * Pass columns name(s) array/string
    *
    */
    public function get_column_label_name($column)
    {

        if (!is_array($column) && strpos($column,",") == False) {
            $column_label = ucwords(str_replace('_',' ',$column));
        }else{
            if (!is_array($column) && strpos($column,",") == True) { $column = explode(",", $column); /* Get Column Name */ }
            for($i = 0; $i < count($column); $i++){
                $column_name = $column[$i]; //Set Current Column Name
                $column_label[$i] =  ucwords(str_replace('_',' ',$column_name)); //Get Current Column Label Name
            }
        }

        return $column_label; //Column Label Name
    }

    /*
    *
    * Set Validation Session Data
    *
    * This function allow you to change validation Session Data with Ease during validation Process
    * This function accept
    *
    * Session Data as Array=>Key
    *
    */
    public function validation_session($validation)
    {
        //Set Session Data
        $filename = (array_key_exists("file_name",$validation))? $validation['file_name'] : session()->get($this->sessionName('file_name')); //File Name
        $required = (array_key_exists("file_required",$validation))? $validation['file_required'] : session()->get($this->sessionName('file_required')); //Required

        //Set Upload File Values
        $file_upload_session = array('file_name'=>$filename,'file_required'=>$required);
        session()->put($file_upload_session);
    }

    /*
    *
    * Get User Profile
    * This function is used to get user profile is isset
    *
    * Pass user ID (If null -> session ID will be take)
    * Pass user Profile Keyname (By default is user-profile)
    * Pass Default Optional Profile [Pass either yes/no] (By default it will use level from user_level)
    */
    public function userProfile($userId=null,$profileKey='user_profile',$userDefault=null)
    {

        //Load Crud
        $CoreCrud = new CoreCrud;

        //User ID
        $user = (is_null($userId))? session()->get($this->sessionName('id')) : $userId;
        //User Level
        $level = $CoreCrud->selectSingleValue('users','level',array('id'=>$user));

        //Default Profile
        $userDefault = $CoreCrud->selectSingleValue('levels','default',array('name'=>$level));
        //Profile Name
        $optionalProfile = ($userDefault == 'yes')? 'assets/admin/img/profile-pics/admin.jpg' : 'assets/admin/img/profile-pics/user.jpg';

        //Get Profile
        $details = $CoreCrud->selectSingleValue('users','details',array('id'=>$user));
        $detail = json_decode($details, True);
        //Check Profile
        if (array_key_exists($profileKey,$detail)){
            $user_profile = json_decode($detail[$profileKey], True); //User Profile Array
            $profile = $user_profile[0]; //Profile Picture
        }else{
            $profile = null; //No Profile Set
        }

        //Get Profile
        $profile = (is_null($profile)) ? $optionalProfile : $profile;
        return $profile;
    }

    /*
    *
    * Get Form and Set Data into Field Format
    *
    * 1: Pass FormData 
    * 2: Pass 'customfields' ID/Title to macth the Field Form
    * 3: Pass unsetData By Default is null
    * 4: Pass Unset Before/After NB: By Default it will unset Before, To Unset After Pass | after
    *
    * retuned DATA is ready for Inserting
    */
    public function getFieldFormatData($formData,$fieldSet,$unsetData=null,$unsetKey='before')
    {

        //Load
        $CoreCrud = new CoreCrud;

        //Module
        $Module = 'field';

        //Check Field Type
        $whereTYPE = (is_numeric($fieldSet))? 'id' : 'title';

        //Table Select & Clause
        $customFieldTable = $this->pluralize('customfields');

        $columns = array('title as title,filters as filters,default as default');
        $where = array($whereTYPE => $fieldSet);
        $fieldList = $CoreCrud->selectCRUD($customFieldTable,$where,$columns);

        $field_title = $fieldList[0]->title; //Title Title
        $field_filter = json_decode($fieldList[0]->filters, True); //FIlter List
        $field_default = $fieldList[0]->default; //Default

        //Set Filters
        $column_filters = strtolower($this->get_column_name($Module,'filters'));

        //Set Values For Filter
        for($i = 0; $i < count($field_filter); $i++){
            $valueFilter = $field_filter[$i]; //Current Value
            $newFilterDataValue[$valueFilter] = $formData[$valueFilter];
        }
        $tempo_filter = json_encode($newFilterDataValue); /* Set Filters */

        //Set Field Data
        $column_data = strtolower($this->get_column_name($Module,'data'));
        $formData[$column_data] = json_encode($formData); //Set Data

        //Prepaire Data To Store
        foreach ($formData as $key => $value) {
            if ($key !== $column_data) {
                $children[$key] = $value;
                $formData = $CoreCrud->unsetData($formData,array($key)); //Unset Data
            }
        }

        //Set Filters
        $formData[$column_filters] = $tempo_filter; /* Set Filters */

        //Set Title/Name
        $column_title = strtolower($this->get_column_name($Module,'title'));
        $formData[$column_title] = $field_title; //Set Title

        //Column Stamp
        $stamp = strtolower($this->get_column_name($Module,'stamp'));
        $formData[$stamp] = date('Y-m-d H:i:s',time());
        //Column Flg
        $flg = strtolower($this->get_column_name($Module,'flg'));
        $formData[$flg] = 1;

        //Column Details
        $details = strtolower($this->get_column_name($Module,'details'));

        //Check Unset Key
        if (strtolower($unsetKey) == 'before') {
            $formData = $CoreCrud->unsetData($formData,$unsetData); //Unset Data
            $formData[$details] = json_encode($formData); //Details
        }else{

            $formData[$details] = json_encode($formData); //Details
            $formData = $CoreCrud->unsetData($formData,$unsetData); //Unset Data
        }

        return $formData; //Return Data
    }

    /*
    *
    * Get Form and Set Data into Field Format
    *
    * 
    * 1: Pass FormData 
    * 2: Pass 'customfields' ID/Title to macth the Field Form
    * 3: Pass unsetData By Default is null
    * 4: Pass Unset Before/After NB: By Default it will unset Before, To Unset After Pass | after
    *
    * retuned DATA is ready for Updating
    */
    public function getFieldUpdateData($updateData,$fieldSet,$unsetData=null,$unsetKey='before')
    {

        //Load
        $CoreCrud = new CoreCrud;

        //Module
        $Module = 'field';

        //Check Field Type
        $whereTYPE = (is_numeric($fieldSet))? 'id' : 'title';

        //Table
        $fieldTable = $this->pluralize($Module);
        $customFieldTable = $this->pluralize('customfields');

        //Table Select & Clause
        $where = array($whereTYPE => $fieldSet);
        $columns = array('id as id,title as title,filters as filters,data as data,details as details');
        $resultList = $CoreCrud->selectCRUD($fieldTable,$where,$columns);

        //Table Select & Clause
        $columns = array('id as id,required as required,optional as optional,filters as filters,default as default');
        $where = array('title' => $resultList[0]->title);
        $fieldList = $CoreCrud->selectCRUD($customFieldTable,$where,$columns,'like');

        //$field_filter = $fieldList[0]->filters; //FIlter List
        $field_filter = json_decode($fieldList[0]->filters, True); //FIlter List
        $field_default = $fieldList[0]->default; //Default

        //Set Filters
        $column_filters = strtolower($this->get_column_name($Module,'filters'));
        //Set Values FOr Filter
        for($i = 0; $i < count($field_filter); $i++){
            $valueFilter = $field_filter[$i]; //Current Value
            if (array_key_exists($valueFilter,$updateData)) {
                $newFilterDataValue[$valueFilter] = $updateData[$valueFilter];
            }
        }
        $current_filter = json_decode($resultList[0]->filters, True); //FIlter List
        foreach ($newFilterDataValue as $key => $value) { $current_filter["$key"] = $value; /* Update -> Data */ }

        $tempo_filter = json_encode($current_filter); /* Set Filters */

        //Set Field Data
        $column_data = strtolower($this->get_column_name($Module,'data'));
        $current_data = json_decode($resultList[0]->data, True); //Get Current Data
        foreach ($updateData as $key => $value) { $current_data["$key"] = $value; /* Update -> Data */ }
        $updateData[$column_data] = json_encode($current_data); //Set Data

        //Prepaire Data To Store
        foreach ($updateData as $key => $value) {
            if ($key !== $column_data) {
                $children[$key] = $value;
                $updateData = $CoreCrud->unsetData($updateData,array($key)); //Unset Data
            }
        }

        //Set Filters
        $updateData[$column_filters] = $tempo_filter; /* Set Filters */

        //Details Column Update
        $details = strtolower($this->get_column_name($Module,'details'));
        $current_details = json_decode($resultList[0]->details, true);

        //Check Unset Key
        if (strtolower($unsetKey) == 'before') {
            $updateData = $CoreCrud->unsetData($updateData,$unsetData); //Unset Data
            foreach ($updateData as $key => $value) { $current_details["$key"] = $value; /* Update -> Details */ }
            $updateData["$details"] = json_encode($current_details);
        }else{
            foreach ($updateData as $key => $value) { $current_details["$key"] = $value; /* Update -> Details */ }
            $updateData["$details"] = json_encode($current_details);
            $updateData = $CoreCrud->unsetData($updateData,$unsetData); //Unset Data
        }

        return $updateData; //Return Data
    }

    /*
    *
    * This function is to check if array key Exist
    * 1: Pass key Required (can be single value, array, ore string separated by comma)
    * 2: Optional ArrayData to check if it has a particular key | else set this using session 'arrayData'
    * 
    * NB:
    * If you pass single key value, the result will be True/False
    * Else is an array will be returned
    * 
    */
    public function checkKeyExist($key,$array=null)
    {

        //By Default - Not Found
        $found = false;

        //Check Array Data
        $arrayData = (!is_null($array))? $array : $this->session->arrayData;

        //Check Passed Data
        if (count($arrayData) > 0) {
            //If Key Is not array
            if (!is_array($key)) {
                $keyData = explode(',',$key);
            }

            //Check Data
            for ($i=0; $i < count($keyData); $i++) { 
                $currentKey = $keyData[0];
                if (array_key_exists($currentKey,$arrayData)) {
                    $found[$currentKey] = true; //Found
                }else{
                    $found[$currentKey] = false; //Not Found
                }
            }

            //Count Found | if is equal to 1 return single value else return array of results
            if (count($found) == 1) {
                $arratKeys = array_keys($found); //Found Key
                $foundKey = $arratKeys[0]; //Single Key
                $found = $found[$foundKey]; //Return Value
            }
        }

        return $found; //Found-NotFound (True,False)   
    }

    /*
    *
    * This function checks if directory/file exists
    * 1: Pass dir/file full path/ path & name | as required by Core Lite
    * 2: Create dir/file (By default dir/file will be created)
    * 3: Permission By default is 0755
    *
    * NB:
    * You can override this by creating function dirCreate() in CoreField
    * -> This will return false if director do not exist
    * -> Also you can overide permission form 0755
    *
    * --> By default dir will be created hence returned TRUE
    * 
    */
    public function checkDir($path,$create=true,$defaultpath='../assets/media',$permission=0755,$recursive=true)
    {
        //load ModelField
        $CoreField = new CoreField;

        //Folder Path
        $pathFolder = realpath(APPPATH . $defaultpath); //Real Path
        $newDirectory = $pathFolder.$path;// New Path | New APPATH Directory

        //Check Additonal Config
        if (method_exists('CoreField', 'changeDirData')) {
            //Config
            $configDir = $CoreField->changeDirData($newDirectory,$permission,$recursive);
            $newDirectory = $configDir['dir']; // New Path | New APPATH Directory
            $permission = $configDir['permission']; //Deafault
            $recursive = $configDir['recursive']; //Deafult
        }

        //Check Dir/File 
        if (!file_exists($newDirectory)) {
            if ($create) {
                mkdir($newDirectory, $permission, $recursive); // Create Directory
                $status = true;// //Folder or file created
            }else{
                $status = false;// Folder or file could not be created
            }
        }else{
            $status = true;// //Folder or file exist
        }

        return $status; //Return Status
    }

    /*
    *
    * Get Parent Children
    * Pass Parent Element ID
    * 
    */
    public function childTreee($parent_id=0,$sub_mark='',$selectedID=null,$type=null)
    {

        //Load
        $CoreCrud = new CoreCrud;
        $CoreField = new CoreField;

        //load ModelField
        if (is_null($type)) {
            $setChildTree = ((method_exists('CoreField', 'setChildTree')))? $CoreField->setChildTree(): false;

            //Set Type
            $type = (!setChildTree)?'category' : $setChildTree;
        }

        //Select Data
        $inheritance = $CoreCrud->selectInheritanceItem(array('parent' =>$parent_id,'flg'=>1,'type'=>$type)
            ,'id,parent,title');

        // Check IF Result Found
        if (count($inheritance) > 0) {
            for ($i=0; $i < count($inheritance); $i++) { 
                $parent = $inheritance[$i]->inheritance_parent; //Parent
                $title = $inheritance[$i]->inheritance_title; //Title
                $id = $inheritance[$i]->inheritance_id; //Id

                //Echo Data
                if ($selectedID == $id) {
                    echo "<option class='$id' value='$id' selected>";
                        echo $sub_mark.ucwords($title);
                    echo "</option>";
                }else{
                    echo "<option class='$id' value='$id'>";
                        echo $sub_mark.ucwords($title);
                    echo "</option>";
                }

                //Check More Child
                return $this->childTreee($id,$sub_mark='---',$selectedID);
            }
        }
    }

    /*
    *
    * Get Element Parent ID
    *
    * Pass elementID and it will return it's Parent ID
    * 
    */
    public function getParentInheritance($inheritanceID,$parentID=0)
    {

        //Load
        $CoreCrud = new CoreCrud;

        //Select Parent
        $parent = $CoreCrud->selectSingleValue('inheritances','parent',array('id'=>$inheritanceID));

        //Check If is Parent
        if ($parent == $parentID) {
            return $inheritanceID; //Parent Value
        }else{
            return $this->getParentInheritance($parent); //Find Parent
        }
    }

    /*
    *
    * Email
    * Get email data & configuration
    * 
    */
    /**
     * @return mixed
     */
    public function email_config()
    {

        //Load
        $CoreCrud = new CoreCrud;
        $CoreField = new CoreField;

        //Get Send Data
        $settings['mail_protocol'] = $CoreCrud->selectSingleValue('settings','value',array('title'=>'mail_protocol'));
        $settings['smtp_host'] = $CoreCrud->selectSingleValue('settings','value',array('title'=>'smtp_host'));
        $settings['smtp_user'] = $CoreCrud->selectSingleValue('settings','value',array('title'=>'smtp_user'));
        $settings['smtp_pass'] = $CoreCrud->selectSingleValue('settings','value',array('title'=>'smtp_pass'));
        $settings['smtp_port'] = $CoreCrud->selectSingleValue('settings','value',array('title'=>'smtp_port'));
        $settings['smtp_timeout'] = $CoreCrud->selectSingleValue('settings','value',array('title'=>'smtp_timeout'));
        $settings['smtp_crypto'] = $CoreCrud->selectSingleValue('settings','value',array('title'=>'smtp_crypto'));
        $settings['wordwrap'] = $CoreCrud->selectSingleValue('settings','value',array('title'=>'wordwrap'));
        $settings['wrapchars'] = $CoreCrud->selectSingleValue('settings','value',array('title'=>'wrapchars'));
        $settings['mailtype'] = $CoreCrud->selectSingleValue('settings','value',array('title'=>'mailtype'));
        $settings['charset'] = $CoreCrud->selectSingleValue('settings','value',array('title'=>'charset'));

        //load ModelField
        $emailConfig = ((method_exists('CoreField', 'emailConfig')))? $CoreField->emailConfig(): false;

        //Configs
        if ($emailConfig) {
            foreach ($emailConfig as $key => $value) {
              $settings[$key] = $value; //Settings
            }
        }

        //Check For Null Values
        foreach ($settings as $key => $value) {
            if (is_null($value) || empty($value)) {
                $CoreCrud->unsetData($settings,array($key));
            }else{
                $config[$key] = $value; //Clean Values
            }
        }

        return $config; //Return Configs
    }

    /*
     *
     * This is a function allowing you to pluralize and return the pluralized value
     * This function accepts one parameter
     *
     * Pass String value to be pluralized
     */
    public function pluralize($value)
    {
        //This pluralizes the string value
        $plural = Str::plural($value);
        return $plural;//return
    }

    /*
    *
    * This is a function allowing you to singularize and return the singularize value
    * This function accepts one parameter
    *
    * Pass String value to be singularize
    */
    public function singularize($value)
    {

        //This pluralizes the string value
        $singularize = Str::singular($value);
        return $singularize;//return
    }


    public function getWhereClause($whereColumn)
    {
        $i = 0;
        foreach ($whereColumn as $key => $value) {
            $getWhere[$i] = "['$key', '=', '$value']";
            $i++;
        }


        return $getWhere;
    }

    /*
    *
    * Set session name
    * -> This function used to generate session names
    * 1: Pass name of the session you wish to generate
    * 2: Pass Optional custom prefix
    */
    public function sessionName($name,$prefix=null)
    {

        //Load
        $CoreCrud = new CoreCrud;

        //Check if prefix is given
        $prefix = (is_null($prefix))? $CoreCrud->selectSingleValue('setting','value',array('title'=>'theme_title','flg'=>1)): $prefix;
        $prefix = substr(preg_replace("/[^ \w-]/", "", stripcslashes($prefix)),0, 7);
        $prefix = str_replace(" ", "",strtolower(trim($prefix)));

        //Return Session Name
        $session = $prefix."_".$name;
        return $session;
    }

}
