<?php 
//load Field
use App\CoreField;
$CoreField = new CoreField;

//Show Field
echo ((method_exists($CoreField, 'incl_Footer')))? $CoreField->incl_Footer($load_script=null):''; 

?>