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
if($action == "sendpsw") {
	if($email == "") {
		$error = "Debe especificar una dirección de e-mail.";
	}
	if($user1 == "") {
		$error = "Debe especificar un nombre de usuario.";
	} else {
		if(!isset($users[$user1]["email"]) || !isset($users[$user1])) {
			$error = "Usuario o e-mail incorrectos.";
		} else {
			if(isset($users[$user1]["email"]) && ($users[$user1]["email"] != $email)) {
				$error = "E-mail incorrecto.";
			} else {
				// Subject
				$subject = "Recordatório $site_name";
				// Message
				$message = "Ud. ha requerido recordar su contraseña en $site_name\n\n";
				$message = $message . "Su contraseña es " . $users[$user1]["password"] . "\n\n";
				$message = $message . "\n\n";
				$message = $message . "Atte.\nAdministrador";
				// Send e-mail
				mail($email, $subject, $message, "From: $mail_admin");
			}
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