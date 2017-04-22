<?php
/**********************************************************************
Copyright (c) 2003, 2005 Alfer Soft Corp.
All rights reserved.
License available at
http://www.alfersoft.com.ar/fpv/license.html

Alfredo Vicente <avicente@ciudad.com.ar>
Fernando Vicente <fvicente@ciudad.com.ar>
**********************************************************************/

/*
 * Add new users:
 * $users["user"]["password"]="mypsw";
 * $users["user"]["level"]=50;
 */

$handle = fopen(".users.php", "r");
while(!feof($handle)) {
	$buffer = fgets($handle, 4096);
	list($user, $pass, $email, $level) = split(":", $buffer, 4);
	if($user != "" && $pass != "" && $level != "") {
		$users[$user]["password"] = $pass;
		$users[$user]["email"] = $email;
		$users[$user]["level"] = $level;
	}
}
fclose($handle);

?>