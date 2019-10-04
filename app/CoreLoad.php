<?php

namespace App;

use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class CoreLoad extends Model
{

    /* Model Instances */
    private $CoreCrud;
    private $CoreField;
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
        $this->CoreField = new CoreField;
        $this->CoreForm = new CoreForm;

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

        //Loading Core CMS Version
        $data['version'] = '4.12';
        $data['copyright_footer_1'] = "Copyright &copy; 2019 Core Lite ".$data['version']." | Published 16-August-2019";
        $data['copyright_footer_2'] = "Powered by Core-Lite Team";

        //Values Assets
        $data['assets'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'assets','flg'=>1));
        $data['ext_dir'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'ext_dir','flg'=>1));
        $data['ext_assets'] = $this->ext_asset();

        //Theme Assets
        $data['theme_name'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'theme_name','flg'=>1));
        $data['theme_dir'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'theme_dir','flg'=>1));
        $data['theme_assets'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'theme_assets','flg'=>1));

        //Site Title
        $data['site_title'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'site_title','flg'=>1));
        $data['description'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'seo_description','flg'=>1));
        $data['keywords'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'seo_keywords','flg'=>1));
        $data['site_robots'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'seo_visibility','flg'=>1));
        $data['site_global'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'seo_global','flg'=>1));
        $data['seo_data'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'seo_meta_data','flg'=>1));

        $data['CoreCrud'] = new CoreCrud;
        $data['CoreForm'] = new CoreForm;
        $data['CoreLoad'] = new CoreLoad;

        //Load Custom Data
        $customData = $this->CoreField->loadData();
        $data = array_merge($data,$customData);

        //returned DATA
        return $data;
    }

    /*
    *
    * This function help the system to load the values needed for a particular page to oparate
    * Thing like page articles, page templates etc are loaded here
    * It accept value page ID/ page Template (if you do not wish to load other page assest)
    *
    */
    public function open($pageSET=null)
    {

        //Call Requred Site Data
        $data = $this->loadData();
        //Check Page Type
        if (is_numeric($pageSET)) {
            //Values
        }else{
            //Page Name
            $data['site_page'] = $pageSET;
        }
        //returned DATA
        return $data;
    }

    /*
    *
    * This Function is for checking if the system is set to be online.
    * When this function is called it will check if site_status on settings table is set to be online
    * if is online it will return TRUE else it will return FALSE
    *
    */
    public function site_status()
    {
        //Site Status
        $status = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'site_status','flg'=>1));

        //Check if is online
        if (strtolower($status) == 'online') {
            return TRUE; //Site is online
        }else{
            return FALSE; //Site is offline
        }
    }


    /*
    * This function allow user to generate random string or integer to be used as unique ID
    * The function accept variable lenght as integer 
    *  -- This variable set the lenght of your random string or variable, by default is set to 4
    *
    * The second parameter is values to be used to generate the random string au integer
    * E.g If you pass '12345' the random integer will be generated from randomized number 1 2 3 4 5  
    *     If you do not pass anything here we advise you only do this when generating password
    */
    public function random($length=4, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ{[}}-+*#')
    {

        //Generate Random String
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString; // Return Random String
    }

    /*
    *
    *  This function clean and return the inputs from your POST or Get request
    *  The function accept two parameters
    *  1: The value is the post data array you wish to get
    *     E.g <input name='firstName' value="">
    *         This form in Post or Get request it array Key name is firstName
    *         That is the $value to be passed |i.e $value = 'firstName';
    *
    *    If this is left as null or passed as null, the function will return all data inside your post/get request. 
    *    This is best if you want to store all data in one array or as JSON data later
    *
    *  2: the rule parameter is to determine if you want data from POST/GET value
    *  
    */
    public function input($value=null,$rule='post')
    {
        //Set the rule to lower string
        $rule = strtolower($rule);

        //Input Value
        $value = (is_null($value))? Input::$rule() : Input::$rule($value); //Set Value
        $input = array();

        // echo "<pre>";
        //     print_r($value);
        // die;
        //Check specific value in Post/Get Array
        if (is_array($value)) {
            $value = $this->CoreCrud->unsetData($value,array('_token'));
            foreach ($value as $key => $item) {
                if (!is_array($item)) {
                    $input[$key] = trim(addslashes($item));
                }else{
                    $input[$key] = $item;
                }
            }
        }else{
            $input = trim(addslashes($value));
        }

        //returned DATA
        return $input;
    }


    /*
    *
    *  This is function to help get corret URL
    *  N:B site_url and base_url can do simillar thing
    * 
    */
    public function siteURL($url=null) {

        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";      
        $domainName = $_SERVER['HTTP_HOST'] . '/';

        //returned DATA
        return $protocol . $domainName.$url;
    }

    /*
    * This is Authentication Level Process
    * N:B we do not use this to authenticate user password or username if they are valid. For that is done by Authentication Model
    * 
    * -> This function accept module(array) : You can pass module allowed 
    * -> Second it accept level 
    *    N:B if the user has logged in you do not need to send the level (pass the level variable) in the function
    *        if user has not logged in you have to pass the level else the authentication will fail.
    *    The second value has to be a string e.g admin, client, report etc
    *
    *  How It Works
    *   -> Module : they are more like access level allowed to access the particluar modules
    *   -> level : the currect level of the user as in users(Table) - user_level(column)
    *              by default the level is accessed by the system via user logged session data $this->session->level so it's not must you pass the user level
    *
    *   -> If user hasn't logged in it will return FALSE
    *   -> If user access level doesn't allow him/her to access the Module it will break the process and oped Access Not Allowed Page
    *
    *   -> If all permission are true/valid it will return TRUE
    * 
    */
    public function auth($module,$level=null)
    {
        //Check If Loged In
        if (session()->get($this->CoreForm->sessionName('logged'))) {
            $level = (is_null($level))? session()->get($this->CoreForm->sessionName('level')) : $level; //Access Level

            $status = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'site_status','flg'=>1));

            $module = $this->CoreForm->singularize($module); //Module Name
            $modules_list = $this->CoreCrud->selectSingleValue('levels','module',array('name'=>$level,'flg'=>1)); //Module List
            $modules = explode(",",strtolower($modules_list)); //Allowed Modules

            if (in_array(strtolower($module), $modules)) { 
                return true;//Auth Allowed
            }elseif (strtolower($level) == 'admin') {
                return true;//Auth Allowed
            }else{
                return false;//Auth Not Allowed
            }
        }else{
            return false;//User Not Logged In
        }
    }

    /*
    *
    * This function is a substute to AUTH
    * The function checks if user has logged in Only
    * The function should only be used to the pages that does not require access level
    *
    * Remember you can do this direct by just checking with if statement $this->session->logged
    * This function does not accept paramenters
    */
    public function logged()
    {
        //Check If Logged In
        if (session()->get($this->CoreForm->sessionName('logged'))) {
            return true; //Logged IN
        }else{
            return false; //Not logged In
        }
    }

    /*
    *
    * This function is a substute to AUTH
    * The function checks if user access level Only
    * The function should only be used to the pages that require access level
    *
    * Remember you can do this direct by just checking with if statement $this->session->level
    * This function does not accept paramenters
    */
    public function level()
    {
        //Check If Logged In
        if (session()->get($this->CoreForm->sessionName('level'))) {
            return true; //Logged IN
        }else{
            return false; //Not logged In
        }   
    }

    /*
    *
    * Get Cookie Name
    * Pass URL
    * Pass Generator
    * 
    */
    public function getCookieName($url=null,$generator='')
    {

        //Domain
        $cookie_name = $this->getDomainName($url); //Host
        $path = $this->getDomainName($url,'path'); //Path

        $cookie =  preg_replace('/[^a-z\d]+/i','_',strtolower(trim($cookie_name.$path.$generator))); //Cookie Name
        return $cookie; //Return
    }

    /*
    *
    * Get Domain Name
    * Fore Cookie USE
    * 
    */
    public function getDomainName($url=null,$return='host')
    {
        //URL
        $url = (is_null($url) || empty($url))? base_url() : $url;
        $url = parse_url($url); //Base URL

        $host_path['host'] = str_replace('www.','',$url['host']); //Host

        $path = (array_key_exists('path', $url))? $url['path'] : ''; //Get Path
        $path = (substr($path, -1) == '/')? substr_replace($path,"",-1) : $path; //Remove last '/' from string

        $host_path['path'] = $path; //Get Path

        return ($return == 'all')? $host_path : $host_path[$return]; //Return Data
    }

    /*
    * 
    * This are messages displayed when system/website is offline 
    * 
    */
    public function siteOffline()
    {
        //Offline Message
        $offlineMessage = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'offline_message','flg'=>1)); //Module List

        //Message
        $htmlDetails = htmlspecialchars_decode($offlineMessage);

        //Return
        echo $htmlDetails; 
    }

    /*
    *
    * User access level is invalid E.g Client tries to access Administartor Page
    * 
    */
    public function notAllowed($error=null)
    {
        //Check If Site is Online
        if ($this->site_status() == TRUE) {
            // Return
            return redirect("error/permission");
        }else{
            return $this->siteOffline(); //Site is offline
        }
    }

    /*
    *
    * This Function is used to load Administrator Menus
    * Pass menu type Eg. Extension,Control,Field or Menu
    * It will look mached menu Category in Setting Table
    * Kindly note set title as extension_menu and in value add JSON ARRAY {"menu_path":"pathfolder/pathfile"}
    *
    * If it wont find any menu it will retun null
    * 
    */
    /**
     * @param null $loadMenu
     * @return |null
     */
    public function menuLoad($loadMenu=null)
    {
        if (!is_null($loadMenu)) {
            $findMenu = $this->CoreForm->singularize($loadMenu); //Make It Singular
            $findMenu = $findMenu.'_menu';

            //Menu Found
            $foundMenu = $this->CoreCrud->selectMultipleValue('setting','value',array('title'=>$findMenu));

            
            for ($i=0; $i < count($foundMenu); $i++) { 
                $menuData = $foundMenu[$i]->setting_value; //Menu Data
                $menu = json_decode($menuData, True);

                $path[$i] = $menu['menu_path']; // Menu Path
            }

            $menuLoaded = (isset($path))? $path : null;
        }else{
            $menuLoaded = null;
        }

        return $menuLoaded; //Return Menu Loaded
    }

    /*
    * Quick get path to your  Extends Assests
    * By Default path start by including Extend Folder and /customfields-or-extensions/filed-or-extension folername
    * 
    */
    public function ext_asset($type='',$load='ext_assets')
    {
        // Extension Path
        $ext_path = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>$load,'flg'=>1)); 
        $path = $ext_path.$type; //New Path

        return $path; //Return Path
    }

}
