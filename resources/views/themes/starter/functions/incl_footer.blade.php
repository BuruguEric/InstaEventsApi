<?php 
//load Field
use App\CoreField;
$CoreField = new CoreField;

//Show Field
echo ((method_exists($CoreField, 'theme_Footer')))? $CoreField->theme_Footer($load_script=null):''; 

?>
