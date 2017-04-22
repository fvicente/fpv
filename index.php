<?php
/**********************************************************************
Copyright (c) 2003, 2005 Alfer Soft Corp.
All rights reserved.
License available at
http://www.alfersoft.com.ar/fpv/license.html

Alfredo Vicente <avicente@ciudad.com.ar>
Fernando Vicente <fvicente@ciudad.com.ar>
**********************************************************************/

require_once "config.php";
require_once "users.php";
require_once "function.php";
include_once "libs/smarty/Smarty.class.php";

global $nombre_sitio, $ancho_sitio;

// create smarty object
$smarty = new Smarty;
$smarty->template_dir = $fpv_path . "/templates";
$smarty->compile_dir = $fpv_path . "/templates_c";
$smarty->cache_dir = $fpv_path . "/cache/templates";
$smarty->config_dir = $fpv_path . "/configs";

// index info
$smarty->assign("site_name", $nombre_sitio);
$smarty->assign("site_width", $ancho_sitio);

// footer info
$smarty->assign("copyright", "© 2005 Todos los derechos reservados");
$smarty->assign("email", "info@fotosparaver.com.ar");

include "body.php";

// menu info
if(checkUser($user, $password)) {
	$smarty->assign("menu_items", array("indice" => "body.tpl", "logout" => "login.tpl", "cambiar contraseña" => "chgpsw.tpl", "registrarse" => "register.tpl"));
} else {
	$smarty->assign("menu_items", array("registrarse" => "register.tpl", "login" => "login.tpl"));
}

$smarty->display("index.tpl");

?>
