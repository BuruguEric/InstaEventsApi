<?php 
//load Field
use App\CoreField;
$CoreField = new CoreField;

//Show Field
echo ((method_exists($CoreField, 'theme_Head')))? $CoreField->theme_Head($load_style=null):''; 

?>
