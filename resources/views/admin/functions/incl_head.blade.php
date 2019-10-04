<?php 
//load Field
use App\CoreField;
$CoreField = new CoreField;

//Show Field
echo ((method_exists($CoreField, 'incl_Head')))? $CoreField->incl_Head($load_style=null):''; 

?>