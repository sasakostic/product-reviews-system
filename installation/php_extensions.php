<?php 
//check if all required extensions are installed
foreach($requirements['extensions'] as $extension){
	echo '<tr><td>';
	echo $extension;
	echo '</td><td>';
	if(extension_loaded($extension)) echo $ok, ' installed'; else {
		$requirements_met = 'no';
		echo $not_ok, ' not installed';
	}
	echo '</td></tr>';
} ?>