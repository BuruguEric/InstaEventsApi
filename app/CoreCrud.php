<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CoreCrud extends Model
{

    /* Model Instances */
    private $CoreForm;

    /*
     *
     * To load libraries/Model/Helpers/Add custom code which will be used in this Model
     * This can ease the loading work
     *
     */
    public function __construct(){

        parent::__construct();

        //libraries

        //Helpers

        //Models
        $this->CoreForm = new CoreForm;

        // Your own constructor code
    }

    /*
    *
    * Set Where clause
    * 1: Pass Module Name 
    * 2: Where clause values as Array
    */
    public function set_whereCRUD($module,$where)
    {

        $module = $this->CoreForm->singularize($module); //Make Sure Module Is Singular

        foreach ($where as $key => $value) {
            //Set Clomun names
            $column = $this->CoreForm->get_column_name($module,$key);
            //Set key as column name and assign the value to look 
            $select_where[$column] = $value;
        }

        //Arrange Where
        foreach ($select_where as $key => $value) {
            $key_where = explode(' ', $key);
            $value_key = (array_key_exists(1, $key_where))? $key_where[1]:'=';
            $array_key = $key_where[0];

            $where_arranged[$array_key] = "$value_key,$value";
        }

        //Return The Array
        return $where_arranged;
    }

    /*
    *
    * Set value To Select
    * 1: Pass module name
    * 2: Pass Column names as sting
    */
    public function set_selectCRUD($module,$column)
    {

        $module = $this->CoreForm->singularize($module); //Make Sure Module Is Singular

        //Get Array
        $column = explode(',',$column[0]);
        $i = 0; // Set Array Counter
        foreach ($column as $key) {
            //Check If Column Requested As
            if (strpos(strtolower($key), 'as') !== false) {
                $exploded = explode("as",strtolower($key)); //Get Column name in Key 0 and As value Name in Key 1

                $column_name = $this->CoreForm->get_column_name($module,$exploded[0]);//Set Column name
                $columns[$i] = $column_name.'as'.$exploded[1];//Set Column name as
            }else{
                $columns[$i] = $this->CoreForm->get_column_name($module,$key);//Set Column name
            }
            $i++;//Count
        }

        //Return The Array
        return $columns;
    }

    /*
    * Use this function to select datble values from the database
    * Select function accept 
    * 1: Module name pluralized to match Table Name
    * 2: Clause (You can Pass Null to get all)
    * 3: what to select (You can Pass Null to get any)
    */
    public function selectCRUD($module,$where=null,$select=null,$clause='where')
    {

        $module = $this->CoreForm->singularize($module); //Make Sure Module Is Singular

        //Get Table Name
        $table = $this->CoreForm->pluralize($module);

        //Query
        $query = DB::table($table);

        if (!is_null($select)) {

            $columns = $this->set_selectCRUD($module,$select);

            $query = $query->select($columns);
        }
        if (!is_null($where)) { 

            $where = $this->set_whereCRUD($module,$where);

            //Where
            if ($clause == 'where') {
                foreach ($where as $key_where => $value_where) {
                    $where_keys = explode(',', $value_where);
                    $where_key = $where_keys[0];
                    $value_where = $where_keys[1];
                    $query = $query->where($key_where,"$where_key",$value_where);
                }
            }else{
                foreach ($where as $key_where => $value_where) {
                    $where_keys = explode(',', $value_where);
                    $where_key = $where_keys[0];
                    $value_where = $where_keys[1];

                    $query = $query->where($key_where,'like',"%$value_where%"); //Select Data
                }
            }
        }

        $query = $query->get();

        $checkData = $this->checkResultFound($query); //Check If Value Found
        $queryData = ($checkData == true)? $query : null;

        return $queryData;
    }

    /*
    *
    * This function is to help user select Inheritance Data
    *
    * By default the function will select inheritance_id,inheritance_type,inheritance_parent.inheritance_title unless specified other wise
    *  
    * 1: Pass The where clause as array('id'=>id_number,'parent'=>parent_id)
    * 2: Pass selected values separated by comma | by default it will select id,type,parent,title
    *
    */
    public function selectInheritanceItem($inheritance_where,$inheritance_select='id,type,parent,title')
    {

        // Select Inheritance Data
        $columns = array($inheritance_select);
        $data = $this->selectCRUD('inheritances',$inheritance_where,$columns);

        return $data; //Return Data
    }

    /*
    * This function help you to select specific fields value from Field Table
    * Kindly not this function wont check if your Field value is Active (field_flg = 1) by default
    * -- It will also not compaire against filter value (If you use filter)
    * 
    * 
    * 1: First parameter to pass is $field_where = To the idetifier value E.g id=>17,title=>User etc. | It has to be an array
    * 2: Pass field value you want to select | also you can pass to return value as e.g registration_date as date, full_name as name
    * N.B must match the field names
    * If you want to select all values from field data, just do not pass second parameter
    * 
    * 3: Optional search type| by default it will search using where you can add like etc
    *
    * Kindly remember these values are selected on field_data column and field_id will be selected by default
    * The function will loop through field_data value to match against your field_select value keys
    *
    * ----> To view the data Decode the Json json_decode($returned_data[array_position],True) 
    * 
    */
    public function selectFieldItem($field_where,$fiel_select='all',$clause='where')
    {

        //Check if fiel_select passed is not an array
        if (!is_array($fiel_select)) {
            $fiel_select = explode(',', $fiel_select); //string to Array
        }

        //Select Data
        $columns = array('id as id,data as data');
        $field_data = $this->selectCRUD('fields',$field_where,$columns,$clause);

        //Check if Query Exceuted And Has Data
        if ($field_data) {

            //Loop through returned field Data
            for ($i=0; $i < count($field_data); $i++) { 

                $field_data_id = $field_data[$i]->id; //Field Data ID
                $field_data_values = json_decode($field_data[$i]->data, True); //Field Data Values

                //Check if user want to select all data
                if ($fiel_select[0] == 'all') {

                    $selected = $field_data_values; //Field Data
                    $selected['id'] = $field_data_id; //Data ID
                    $data[$i] = json_encode($selected, True);// All selected Data
                }else{

                    //Loop through selected values
                    for ($f=0; $f < count($fiel_select); $f++) { 
                        $select = $fiel_select[$f];//Selectd value
                        if (strpos($select, 'as') !== false) {
                            $key_as = explode('as', $select);//Get array Key and As value
                            $key = trim($key_as[0]); //Set Key
                            $as = trim($key_as[1]); //Set As value
                            $field_values[$as] = $field_data_values[$key]; //Set Value
                        }else{
                            $field_values[$select] = $field_data_values[$select]; //Set Values
                        }
                    }

                    //Set Values
                    $selected = $field_values; //Field Data
                    $selected['id'] = $field_data_id; //Data ID

                    $data[$i] = json_encode($selected, True);// All selected Data
                }
            }

            return $data; //return Data
        }else{
            return null; //return null for no data
        }
    }


    /*
     *
     * This function help you to select and retun specific column value
     * You can only select single column value
     *
     * In this function you pass
     *
     * 1: Module name / Table name
     *  -> This will be singularize and used to generate column Name
     *  -> Also pluralize for Table Name
     *
     * 2: Pass the selected column name
     * 3: Pass the comparison values
     *  array('column'=>'value')
     *
     * 4: Pass clause if you want to use Like etc.
     *
     * NB: Full Column Name -- will be added by the function
     *
     */
    public function selectSingleValue($module,$select,$where,$clause=null)
    {

        $module = $this->CoreForm->singularize($module);
        $table = $this->CoreForm->pluralize($module);

        //Columns
        $select_column = $this->CoreForm->get_column_name($module,$select);
        foreach ($where as $key => $value) {

            $column = $this->CoreForm->get_column_name($module,$key);
            $where_column[$column] = $value; //Set Proper Column Name
        }

        //Where - Comparison
        $where_column = $this->set_whereCRUD($module,$where);
        //Select
        $query = DB::table($table);
        //Where - Check If Clause specified
        if (!is_null($clause)) {
            foreach ($where_column as $key_where => $value_where) {
                $where_keys = explode(',', $value_where);
                $where_key = $where_keys[0];
                $value_where = $where_keys[1];

                $query = $query->where($key_where,'like',"%$value_where%"); //Select Data
            }
        }else{
            foreach ($where_column as $key_where => $value_where) {
                $where_keys = explode(',', $value_where);
                $where_key = $where_keys[0];
                $value_where = $where_keys[1];
                $query = $query->where($key_where,"$where_key",$value_where);
            }
        }
        
        $selectData = $query->limit(1)->value($select_column);
        $values = ($selectData)? $selectData : null;

        //Return Data
        return $values;
    }

    /*
    *
    * This function help you to select and retun multiple value
    * You can only select passed column value(s)
    *
    * In this function you pass
    *
    * 1: Module name / Table name
    *  -> This will be singularize and used to generate column Name
    *  -> Also pluralize for Table Name
    *
    * 2: Pass the selected column name(s)
    * 3: Pass the comparison values
    *  array('column'=>'value')
    *
    * 4: Pass clause if you want to use Like etc.
    *
    * NB: Full Column Name -- will be added by the function 
    * 
    */
    public function selectMultipleValue($module,$select,$where,$clause=null)
    {

        //Modules
        $module = $this->CoreForm->singularize($module);
        $table = $this->CoreForm->pluralize($module);

        //Check if select passed is not an array
        if (!is_array($select)) {
            $select = explode(',', $select); //string to Array
        }

        //Set-Up Columns
        for ($i = 0; $i < count($select); $i++) {

            $column = $this->CoreForm->get_column_name($module,$select[$i]);
            $select_column[$i] = $column; //Set Proper Column Name 
        }

        //Where - Comparison
        $where_column = $this->set_whereCRUD($module,$where);
        //Select
        $query = DB::table($table)->select($select_column);
        //Where - Check If Clause specified
        if (!is_null($clause)) {
            foreach ($where_column as $key_where => $value_where) {
                $where_keys = explode(',', $value_where);
                $where_key = $where_keys[0];
                $value_where = $where_keys[1];

                $query = $query->where($key_where,'like',"%$value_where%"); //Select Data
            }
        }else{
            foreach ($where_column as $key_where => $value_where) {
                $where_keys = explode(',', $value_where);
                $where_key = $where_keys[0];
                $value_where = $where_keys[1];
                $query = $query->where($key_where,"$where_key",$value_where);
            }
        }
        
        $selectData = $query->get();
        $values = ($selectData)? $selectData : null;

        //Return Data
        return $values;
    }

    /*
    *
    * Count Table Rows
    * This function will return number of rows in a table selected
    * By Default the function will do selection query only by ID (this is to speedup the selection process) 
    * Then it will count the number of retuned results
    * and return the number
    *
    * This function accept 
    * 1: Table Name | passed as string
    * 2: Clase, a where clause if you want to check specific column value
    *  NB: pass as an array | array('column_name' => 'match_value');
    * 
    */
    public function countTableRows($table,$where=null)
    {

        //Get Table Name
        $table = $this->CoreForm->pluralize($table);

        //Check if Clause Specified
        if (!is_null($where)) {
            //Select
            $columns = array('id');
            $where = array($where);
            $data = $this->selectCRUD($table,$where,$columns);
        }else{
            $columns = array('id');
            $data = $this->selectCRUD($table,null,$columns);
        }

        //Count Number of result
        if (is_array($data)) {
            $row_num = count($data);
        }else{
            $row_num = 0;
        }

        return $row_num; //Number Of Rows
    }


    /*
    *
    * Upload File Data
    * -> Pass Input Name
    * -> Pass Input Location (Upload location)
    * 
    */
    public function upload($inputName,$location='../assets/media',$rule='jpg|jpeg|png|doc|docx|pdf|xls|txt',$link=true,$configs=null)
    {   

        //Upload Data
        $uploaded = $this->uploadFile($_FILES[$inputName],$rule,$location,$link,$configs);
        if (!is_null($uploaded)) {
            $file_link = json_encode($uploaded, true);
        }else{
            $file_link = json_encode(null);
        }
        return $file_link;
    }

    /*
    *
    * Upload File Class
    * The function accept the input data, 
    * validation string and 
    * Upload Location
    * Return Link or Name | By Default it return Name
    * 
    */
    public function uploadFile($input=null,$valid='jpg|jpeg|png|doc|docx|pdf|xls|txt',$file='../assets/media',$link=false,$configs=null)
    {

        //Library
        $this->load->library('upload');

        //Default COnfig Settings
        $filePath = $this->uploadDirecory($file);
        $file = $filePath[1];
        $config['upload_path'] = $filePath[0];
        $config['allowed_types'] = $valid;
        $config['max_size'] = 2048;
        $config['encrypt_name'] = TRUE;

        //load ModelField
        $this->load->model('CoreField');  
        $customConfig = ((method_exists('CoreField', 'uploadSettings')))? $this->CoreField->uploadSettings(): false;
        if ($customConfig) {
            foreach ($customConfig as $key => $value) {
                $config[$key] = $value; //Ovewrite Settings
            }
        }

        //Additional Configs - Passed Through FUnction
        if (!is_null($configs)) {
            foreach ($configs as $key => $value) {
                if ($key == 'compress') {
                    $compressLoad = true;
                }else{
                    $config[$key] = $value; //Ovewrite Settings
                }
            }
        }

        //Check Input
        if (!is_null($input)) {

            $this->upload->initialize($config);

            $key = 0;
            for($i = 0; $i < count($input['name']); $i++){

                $_FILES['photo']['name']     = $input['name'][$i];
                $_FILES['photo']['type']     = $input['type'][$i];
                $_FILES['photo']['tmp_name'] = $input['tmp_name'][$i];
                $_FILES['photo']['error']     = $input['error'][$i];
                $_FILES['photo']['size']     = $input['size'][$i];


                if ($this->upload->do_upload('photo')) {
                    $data_upload = array('upload_data' => $this->upload->data());

                    //Uploaded
                    $file_name = $data_upload['upload_data']['file_name'];

                    //Custom Compress Settings
                    $compressSettings = ((method_exists('CoreField', 'compressSettings')))? $this->CoreField->compressSettings(): false;
                    if ($compressSettings) {
                        foreach ($compressSettings as $key => $value) {
                            $compess[$key] = $value; //Compress Settings
                        }
                    }

                    //Check Additional Compress Configs
                    if (isset($compressLoad)) {
                        $configsCompress = $configs['compress'];
                        foreach ($configsCompress as $key => $value) {
                            $compess[$key] = $value; //Ovewrite  Compress Settings
                        }
                    }

                    //Compresss File
                    if (isset($compess)) {
                        $image_source = trim(str_replace("../", " ",trim($file)).'/'.$file_name);
                        //Source
                        $compess['source_image'] = "./$image_source";
                        $file_name = ((method_exists('CoreField', 'compressImage')))? $this->CoreField->compressImage($compess): $file_name;
                    }

                    //Return
                    if ($link == true) {
                        $file_uploaded[$key] = trim(str_replace("../", " ",trim($file)).'/'.$file_name);
                        $key++;
                    }else{
                        $file_uploaded[$key] = $file_name;
                        $key++;
                    }
                }else{
                    $file_uploaded[$key] = null;
                }
            }
            return $file_uploaded;
        }else{
            return null;
        }
    }

    /*
    *
    * File Path/Directory
    * -> Pass where you wish file to be uploaded.
    *
    * This function will check if in the director Folder arranged by
    * == Year - Month - Date
    *
    * If not it will create the folders and return appropiate URL to upload
    *
    * NB: To overide this function | pass FALSE after URL
    * 
    */
    public function uploadDirecory($path='../assets/media',$default=true)
    {

        //Check IF Deafult
        if ($default) {

            $file_path = '/'.date('Y').'/'.date('m').'/'.date('d'); //Suggested Path
            $pathFolder = realpath(APPPATH . $path); //Real Path

            $newDirectory = $pathFolder.$file_path;// New Path | New APPATH Directory
            $permission = 0755; //Deafault
            $recursive = True; //Deafult

            //Check Additonal Config
            if (method_exists('CoreField', 'changeDirData')) {
                //Config
                $configDir = $this->CoreField->changeDirData($newDirectory,$permission,$recursive);
                $newDirectory = $configDir['dir']; // New Path | New APPATH Directory
                $permission = $configDir['permission']; //Deafault
                $recursive = $configDir['recursive']; //Deafult
            }

            // Create Directory
            if (!file_exists($newDirectory)) {
                mkdir($newDirectory, $permission, $recursive);
            }

            $uploadTo = $path.$file_path; //New Path
            $path_url = array($newDirectory,$uploadTo); //Upload Path
        }else{
            $path_url = array(realpath(APPPATH . $path),$path);      
        }

        return $path_url; // Return PATH
    }

    /*
    *
    * Delete Image/File Class
    * The function accept the file stored path, 
    *
    */
    public function deleteFile($path)
    {

        //File URL
        $file = "../".$path;

        //Base FIle URL
        $filelocated = realpath(APPPATH . $file);//New APPATH Directory

        if ($filelocated) {
            //Check If File Exist
            if (file_exists($filelocated) === True) {
                //Delete FIle
                unlink($filelocated);
            }
        }
    }

    /*
    *
    * Generate Url From Title
    * 
    */
    public function postURL($postID,$currURL=null,$module='page')
    {

        //Modules
        $module = $this->CoreForm->singularize($module);
        $table = $this->CoreForm->pluralize($module);

        //Columns
        $page_column_id = $this->CoreForm->get_column_name($module,'id');
        $page_column_title = $this->CoreForm->get_column_name($module,'title');
        $page_column_createdat = $this->CoreForm->get_column_name($module,'createdat');
        $page_column_url = $this->CoreForm->get_column_name($module,'url');

        //Select Post
        $postData = DB::table($table)->select($page_column_id,$page_column_title)->where($page_column_id,$postID)
        ->orderBy($page_column_createdat,'desc')->limit(1)->get();

        //Url Format
        $current_url = $this->selectSingleValue('settings','value',array('title'=>'current_url','flg'=>1));

        if (strtolower($current_url) == 'title') {

            if (!is_null($currURL)) {
                $post_url = substr(preg_replace("/[^ \w-]/", "", stripcslashes($currURL)),0, 50);
            }else{
                $post_url = substr(preg_replace("/[^ \w-]/", "", stripcslashes($postData[0]->$page_column_title)),0, 50);
            }

            $url = str_replace(" ", "-",strtolower(trim($post_url)));
            $URL = DB::table($table)->select($page_column_url)->where($page_column_url,'like',"%$url%")
            ->orderBy($page_column_createdat,'desc')->limit(1)->get();

            if (!empty($URL)) {
                $post_url = $url.'-'.$postData[0]->$page_column_id;
            }else{
                $post_url = $url;
            }    
        }elseif (strtolower($current_url) == 'get') {
            if (!is_null($currURL)) {
                $post_url = substr(preg_replace("/[^ \w-]/", "", stripcslashes($currURL)),0, 50);
            }else{
                $post_url = substr(preg_replace("/[^ \w-]/", "", stripcslashes($postData[0]->$page_column_title)),0, 50);
            }

            $url = str_replace(" ", "-",strtolower(trim($post_url)));
            $URL = DB::table($table)->select($page_column_url)->where($page_column_url,'like',"%$url%")
            ->orderBy($page_column_createdat,'desc')->limit(1)->get();

            if (!empty($URL)) {
                $post_url = '?p='.$url.'-'.$postData[0]->$page_column_id;
            }else{
                $post_url = '?p='.$url;
            }    
        }else{
            $post_url = $postData[0]->$page_column_id;
        }

        return $post_url;
    }

    /*
    *
    * Check If Same URL Exist
    */
    public function checkURL($currURL,$currPOST,$module='page')
    {

        //Modules
        $module = $this->CoreForm->singularize($module);
        $table = $this->CoreForm->pluralize($module);

        //Columns
        $page_column_id = $this->CoreForm->get_column_name($module,'id');
        $page_column_title = $this->CoreForm->get_column_name($module,'title');
        $page_column_createdat = $this->CoreForm->get_column_name($module,'createdat');
        $page_column_url = $this->CoreForm->get_column_name($module,'url');

        //Select Data
        $URL = DB::table($table)->select($page_column_id,$page_column_title,$page_column_url)->where($page_column_id,$currPOST)
        ->orderBy($page_column_createdat,'desc')->limit(1)->get();
        if ($URL[0]->$page_column_url == $currURL) {
            return $currURL;
        }else{
            return $this->postURL($URL[0]->$page_column_id,$currURL);
        }
    }

    /*
    *
    * This function allow user to remove array key and it's value from the data
    * The two parameters passed are
    * 1: $passedData - the array containing full data
    * 2: $unsetData - the value you wish to be removed from the array
    *
    *  -> The function will return the remaining of the data
    */
    public function unsetData($passedData,$unsetData=null)
    {
        if (!is_null($unsetData)) {
            //Set Array If it is String
            if (!is_array($unsetData)) {
                $unsetData = explode(",",$unsetData); //Produce Array
            }
            //Unset Data
            for($i = 0; $i < count($unsetData); $i++){
                $unset = $unsetData[$i]; //Key Value To Remove
                unset($passedData["$unset"]); //Remove Item
            }
            return $passedData; //Remaining Data AFter Unset
        }
        else{
            return $passedData; //All Data Without Unset
        }
    }

    /*
    *
    * This function allow query to be counted before selection
    * Means when you want to select a value use this query to make sure the value exist
    * It will avoid error
    * NB: This is mostly used by the system
    *
    */
    public function checkResultFound($query)
    {
        if (count($query) > 0){
            return true;
        }else{
            return false;
        }
    }

    /*
    *
    * Destroy Data Session
    *  This function will destroy all page session values
    *  For specific session pass session ID/name as array
    *  
    */
    /**
     * @param null $sessionData
     */
    public function destroySession($sessionData=null)
    {

        //Check If Session Key(name/id) was Passed
        if (!is_null($sessionData)) {

            //Destroy specific session item
            for ($i=0; $i < count($sessionData); $i++) { 

                $item = $sessionData[$i]; //Destroy Session Item

                //Check If Session Key is Set
                if (session()->has($item)) {
                    session()->forget($item); //Destroy Session
                }
            }
        }else{
            session()->flush();// Destroy all session data
        }
    }
}

