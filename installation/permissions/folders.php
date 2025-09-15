<?php 

//check if all required folders are writable
foreach($requirements['folders_permissions'] as $folder => $permission){
	echo '<tr><td>';
	echo $folder;
	echo '</td><td>';
	$check_permission = substr(sprintf('%o', fileperms($folder)), -4);
	if($check_permission >= $permission)
	{
		echo $ok, ' writable ';
	} else {
		echo $not_ok, ' not writable, set permissions to '.$permission;
		$requirements_met = 'no';
	}
	echo '</td></tr>';

}?>