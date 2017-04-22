<?php
/**********************************************************************
Copyright (c) 2003, 2005 Alfer Soft Corp.
All rights reserved.
License available at
http://www.alfersoft.com.ar/fpv/license.html

Alfredo Vicente <avicente@ciudad.com.ar>
Fernando Vicente <fvicente@ciudad.com.ar>
**********************************************************************/

global $users;

$action = "";
if(isset($_POST['action'])) {
	$action = $_POST['action']; 
}
$password1 = "";
if(isset($_POST['password1'])) {
	$password1 = $_POST['password1']; 
}
$newpsw1 = "";
if(isset($_POST['newpsw1'])) {
	$newpsw1 = $_POST['newpsw1']; 
}
$newpsw2 = "";
if(isset($_POST['newpsw2'])) {
	$newpsw2 = $_POST['newpsw2']; 
}
$user1 = "";
if(isset($_POST['user1'])) {
	$user1 = $_POST['user1']; 
}

$error = "";
while($action == "chgpsw") {
	if($user1 == "") {
		$error = "Debe especificar un nombre de usuario.";
		break;
	}
	if($password1 == "") {
		$error = "Debe especificar la contraseña actual.";
		break;
	}
	if($newpsw1 == "" || $newpsw2 == "") {
		$error = "Debe especificar la nueva contraseña y la repetición.";
		break;
	}
	if($newpsw1 != $newpsw2) {
		$error = "La nueva contraseña debe coincidir con la repetición.";
		break;
	}
	if(!checkUser($user1, md5($password1))) {
		$error = "Usuario o password incorrectos.";
		break;
	}
	break;
}

if($error != "") {
	$action = "";
} else {
	// Change password
	changePsw($user1, $password1, $newpsw1);
}

$smarty->assign("action", $action);
$smarty->assign("error", $error);

?>