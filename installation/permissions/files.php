<?php

//check if all required files are writable
foreach($requirements['files_permissions'] as $file => $permission){
	echo '<tr><td>';
	echo $file;
	echo '</td><td>';
	$check_permission = substr(sprintf('%o', fileperms($file)), -4);
	if($check_permission >= $permission)
	{
		echo $ok, ' writable ';
	} else {
		echo $not_ok, ' not writable ';
		$requirements_met = 'no';
	}
	echo '</td></tr>';

}
?>