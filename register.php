<?php
/**********************************************************************
Copyright (c) 2003, 2005 Alfer Soft Corp.
All rights reserved.
License available at
http://www.alfersoft.com.ar/fpv/license.html

Alfredo Vicente <avicente@ciudad.com.ar>
Fernando Vicente <fvicente@ciudad.com.ar>
**********************************************************************/

global $users, $site_name, $mail_admin;

$action = "";
if(isset($_POST['action'])) {
	$action = $_POST['action']; 
}
$email = "";
if(isset($_POST['email'])) {
	$email = $_POST['email']; 
}
$user1 = "";
if(isset($_POST['user1'])) {
	$user1 = $_POST['user1']; 
}

$error = "";
if($action == "register") {
	if($email == "") {
		$error = "Debe especificar una direcci�n de e-mail.";
	}
	if($user1 == "") {
		$error = "Debe especificar un nombre de usuario.";
	} else {
		if(isset($users[$user1]["password"]) || isset($users[$user1])) {
			$error = "El usuario $user1 ya existe, por favor seleccione otro nombre.";
		} else {
			$regcode = rand(999999, 9999999);
			$users[$user1]["password"] = $regcode;
			$users[$user1]["email"] = $email;
			$users[$user1]["level"] = -1;
			saveUserFile();

			// Subject
			$subject = "Registraci�n en $site_name";
			// Message
			$message = "El usuario $user1 fue registrado en $site_name\n\n";
			$message = $message . "Su contrase�a temporal es $regcode\n\n";
			$message = $message . "Ingrese al sitio http://$site_name y use el nombre de usuario seleccionado y la contrase�a temporal para ver las fotos.\n";
			$message = $message . "Una vez ingresado puede presionar \"cambiar contrase�a\" en el men� superior para cambiar su contrase�a.\n";
			$message = $message . "\n\n";
			$message = $message . "Si usted no pidi� registrarse, ignore este e-mail.\n";
			$message = $message . "Atte.\nAdministrador";
			mail($email, $subject, $message, "From: $mail_admin");
		}
	}
}
if($error != "") {
	$action = "";
}

$smarty->assign("action", $action);
$smarty->assign("email", $email);
$smarty->assign("error", $error);

?>