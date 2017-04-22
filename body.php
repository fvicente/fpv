<?php
/**********************************************************************
Copyright (c) 2003, 2005 Alfer Soft Corp.
All rights reserved.
License available at
http://www.alfersoft.com.ar/fpv/license.html

Alfredo Vicente <avicente@ciudad.com.ar>
Fernando Vicente <fvicente@ciudad.com.ar>
**********************************************************************/

global $dir_base, $max_pages, $max_size, $select_size, $desc_filename, $counter;

$catid = "";
$maxfotos = 6;
$offset = 0;
$page = "index.php";
$order = 0;
$user = "";
$password = "";
$module = "body.tpl";
$edit = 0;

getCookieInfo();

if(isset($_POST['catid'])) {
	$catid = $_POST['catid']; 
}
if(isset($_POST['maxfotos'])) {
	$maxfotos = $_POST['maxfotos']; 
}
if(isset($_POST['offset'])) {
	$offset = $_POST['offset']; 
}
if(isset($_POST['page'])) {
	$page = $_POST['page']; 
}
if(isset($_POST['order'])) {
	$order = $_POST['order']; 
}
if(isset($_POST['edit'])) {
	$edit = $_POST['edit']; 
}
if(isset($_POST['user'])) {
	$user = $_POST['user']; 
} else if(isset($_SESSION['cookie_name'])) {
	$user = $_SESSION['cookie_name'];
}
if(isset($_SESSION['enc_pwd'])) {
	$password = $_SESSION['enc_pwd'];
} else if(isset($_POST['password'])) {
	$password = md5($_POST['password']);
}
$module = "body.tpl";
// load current module
if(isset($_POST['module'])) {
	$module = $_POST['module'];
}
$smarty->assign("module", $module);
$source = "";
switch($module) {
	case "login.tpl":
		$source = "logout.php";
		break;
	case "chgpsw.tpl":
		$source = "chgpsw.php";
		break;
	case "register.tpl":
		$source = "register.php";
		break;
	case "sendpsw.tpl":
		$source = "sendpsw.php";
		break;
}

if($source != "") {
	include $source;
} else {
	// check user logged in
	if(checkUser($user, $password)) {
		if(!isset($_SESSION['cookie_name'])) {
			// first login today
			$counter = increaseAndGetCounter();
		}
		$cookie_name = $user;
		$_SESSION['cookie_name'] = $cookie_name;
		$enc_pwd = $password;
		$_SESSION['enc_pwd'] = $enc_pwd;
		$user_level = getUserLevel($user);
		// first login for this user, set level to 50
		if($user_level == -1) {
			global $users;
			$users[$user]["level"] = 50;
			$user_level = 50;
			saveUserFile();
		}
		setCookieInfo();

		// welcome label
		$smarty->assign("catid", $catid);
		if($catid == "") {
			$smarty->assign("title", "Bienvenido !!");
		} else {
			$smarty->assign("title", "Categorías");
		}
		
		// sort items
		$smarty->assign('order_options', array(
						0 => 'Fecha de archivo',
						1 => 'Fecha de archivo invertido',
						2 => 'Nombre de archivo',
						3 => 'Nombre de archivo invertido'));
		$smarty->assign('order', $order);
	
		// max foto items
		$smarty->assign('maxfotos_options', array(
						3 => '3',
						6 => '6',
						12 => '12',
						16 => '16'));
		$smarty->assign('maxfotos', $maxfotos);
	
		$cant_fotos = getNumberOfFotos($catid);
		$smarty->assign("cant_fotos", $cant_fotos);
		$smarty->assign("linked_path", getLinkPath($catid));
	
		// Recuadro de Categorías / Subcategorías
		$cant_cat = getNumberOfCat($catid);
		$smarty->assign("cant_cat", $cant_cat);
	
		if ($catid == "") {
			$smarty->assign("title_cat", "Categorías ($cant_cat)");
		} else {
			$smarty->assign("title_cat", "Subcategorías ($cant_cat)");
		}
	
		if ($cant_cat > 0) {
			// Divido cat. en 2 columnas
			$porcol = round($cant_cat / 2);
			$dirtoread = $dir_base . $catid . "/";
			$filelist = array();
			if (is_dir($dirtoread)) {
			    if ($dh = opendir($dirtoread)) {
			        while (($file = readdir($dh)) !== false) {
				        if (is_dir($dirtoread . $file) && (!inIgnoreList($file))) {
				        	$filelist[$file]=$catid;
						}
			        }
			        closedir($dh);
			    }
			}
			switch ($order) {
				case 1:
				case 3:
					ksort($filelist);
					break;
				case 0:
				case 2:
				default:
					krsort($filelist);
					break;
			}
			reset($filelist);
			$cat_items = array();
			while (list($file, $val) = each($filelist)) {
				$cantsub = getNumberOfFotos($catid . "/" . $file);
				$cat_items[$file] = $cantsub;
			}
			$smarty->assign("porcol", $porcol);
			$smarty->assign("cat_items", $cat_items);
		}
	
		// Recuadro de imágenes para ésta categoría
		switch ($maxfotos) {
			case 3:
				$maxx = 3;
				break;
			case 12:
				$maxx = 4;
				break;
			case 16:
				$maxx = 4;
				break;
			case 6:
			default:
				$maxx = 3;
				break;
		}
		$totcont = 0;
		$filelist = array();
		$dirtoread = $dir_base . $catid . "/";
		if (is_dir($dirtoread)) {
		    if ($dh = opendir($dirtoread)) {
		        while (($file = readdir($dh)) !== false) {
			        if ((is_file($dirtoread . $file)) && (substr($file, 0, 1) != ".") && (!inIgnoreList($file))) {
						$filelist[$dirtoread . $file]=date("YmdHis", filemtime($dirtoread . $file));
					}
		        }
		        closedir($dh);
		    }
		}
		switch ($order) {
			case 1:
				asort($filelist);
				break;
			case 2:
				krsort($filelist);
				break;
			case 3:
				ksort($filelist);
				break;
			case 0:
			default:
				arsort($filelist);
				break;
		}
		reset($filelist);
		$catinfo = parseCatInfo($catid);
		$foto_items = array();
		$descchanged = 0;
		// check directory permission for edition
		$perms = fileperms($dir_base . $catid . "/");
		$perm_error = "0";
		if(($edit == 1) && !($perms & 0x0012)) {
			$edit = 0;
			$perm_error = "1";
		}
		while (list($key, $val) = each($filelist)) {
	        if (($totcont >= $offset) && ($totcont < ($offset + $maxfotos))) {
	        	$desc = "";
	        	$filename = strtoupper(getFileName($key)); // remove path 
	        	if(isset($catinfo[$filename])) {
	        		$desc = getInfoField($catinfo[$filename], "comment", "");
	        	} 
				FillBoxInfo($foto_items, $key, true, $desc);
				$inptext = str_replace(".", "_", "desc_" . $filename);
				if($edit == 2 && isset($_POST[$inptext])) {
					$newdesc = $_POST[$inptext];
					if($foto_items[$key]["desc"] != $newdesc) {
						$foto_items[$key]["desc"] = $newdesc;
						$catinfo[$filename]["comment"] = $newdesc;
						if($catinfo[$filename]["date"] == "") {
							$catinfo[$filename]["date"] = $foto_items[$key]["date"];
						}
						if($catinfo[$filename]["owner"] == "") {
							$catinfo[$filename]["owner"] = $user;
						}
						$descchanged = 1;
					} 
				}
			}
			$totcont++;
			if ($totcont > ($offset + $maxfotos)) {
				break;
			}
		}
		if($edit == 2) {
			// save changes
			if($descchanged == 1) {
				saveCatInfoFile($catid, $catinfo);
			}
			$edit = 0;
		}
		$smarty->assign("edit", $edit);
		$smarty->assign("perm_error", $perm_error);
		$smarty->assign("user_level", $user_level);
		$smarty->assign("desc_filename", $desc_filename);
		$smarty->assign("select_size", $select_size);
		$smarty->assign("max_size", $max_size);
		$smarty->assign("maxx", $maxx);
		$smarty->assign("foto_items", $foto_items);
		$smarty->assign("user", $user);
		$smarty->assign("counter", $counter);
	
		// Links a otras páginas, anterior y siguiente
		$offset = $offset - $maxfotos;
		$smarty->assign("prev_offset", $offset);
		$tot_pages = ($cant_fotos / $maxfotos);
		$cur_page = ($offset + $maxfotos) / $maxfotos;
		$start = $cur_page - ($max_pages / 2);
		if($start < 0) {
			$start = 0;
		}
		if(($start + $max_pages) > $tot_pages) {
			$start = ($tot_pages - $max_pages);
			if($start < 0) {
				$start = 0;
			}
		}
		$nav_items = array();
		for ($i = 0; $i < $tot_pages; $i++) {
			$from = $i * $maxfotos;
			if(($i >= $start) && ($i < $start + $max_pages)) {
				$nav_items[$from] = array("num" => ($i + 1), "from" => $from);
			}
		}
		$smarty->assign("nav_current", $offset + $maxfotos);
		$offset = $offset + ($maxfotos * 2);
		$smarty->assign("next_offset", $offset);
		$smarty->assign("nav_items", $nav_items);
	} else {
		if($user != "" || $password != "") {
			$smarty->assign("error", "Usuario o Password incorrecto!!");
		}
		$smarty->assign("module", "login.tpl");
	}
}

?>
