<?php $minimal_version = '5.5.9'; 
$current_version = phpversion(); 
if(version_compare( $current_version, $minimal_version, '>=' )) echo $ok, ' ok'; else echo $not_ok, ' minimal required version '.$minimal_version;
?>