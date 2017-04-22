<?php

/**********************************************************************
Copyright (c) 2003, 2006 Alfer Soft Corp.
All rights reserved.
License available at
http://www.alfersoft.com.ar/fpvotg/license.html

Alfredo Vicente <avicente@ciudad.com.ar>
Fernando Vicente <fvicente@ciudad.com.ar>
**********************************************************************/

error_reporting(E_ALL);


$nombre_sitio = "fotos para ver - tus imagenes preferidas... (v0.1.0.6rc1)";
$ancho_sitio = "700";

$dir_base = "files";			# directorio base para fotos no debe incluir "/"
$cache_dir = "cache";			# directorio base para cache no debe incluir "/"
$cache_image_max_days = "30";	                # Si el valor es "0" la imagen no se renovará
$max_size = 0;					# 0 = sin tamaño máximo. > 0 forza tamaño máximo (ancho o alto) cuando el usuario hace click en el thumb
$select_size = 1;				# 0 = no mostrar resoluciones menores. 1 = muestra resoluciones predefinidas
$desc_filename = 1;				# 1 = usar nombre de archivo como descripción
$max_pages = 20;				# máximo de links para salto a otras páginas
$maxfotos = 6;
$accept = array("jpg","png","bmp","flv");	# tipos de archivos que puede mostrar
$ignore = array("thumbs.db", "cvs", ".", "..");
$movie_ext = array("flv","3gp");		# tipos de archivos que son peliculas
$movie_image = "images/movie.jpg";
$fpv_path = getcwd();
$site_name = "fotosparaver.com.ar";
$mail_admin = "admin@fotosparaver.com.ar";

if (isset($_GET['catid'])) {
    $_POST['catid']=$_GET['catid'];
}

setlocale(LC_ALL, "es_AR");

function getInfoField($info, $key, $default) {
	if(isset($info[$key])) {
		return $info[$key];
	} else {
		return $default;
	}
}

function saveCatInfoFile($cat, $info) {

	global $dir_base;

	$tmpdir = $dir_base . $cat . "/";
	$handle = fopen($tmpdir . ".catinfo.php", "w+");
	fwrite($handle, "<?php");
	fwrite($handle, "\n/*");
	foreach($info as $key => $value) {
		if(isset($info[$key])) {
			fwrite($handle, "\n" . $key . ":" . str_replace(":", "..", getInfoField($info[$key], "comment", "")) . ":" . getInfoField($info[$key], "date", "") . ":" . getInfoField($info[$key], "owner", ""));
		}
	}
	fwrite($handle, "\n*/");
	fwrite($handle, "\n?>");
	fclose($handle);
}

function parseCatInfo($cat) {
	
	global $dir_base;

	$tmpdir = $dir_base . $cat . "/";
	$handle = @fopen($tmpdir . ".catinfo.php", "r");
	if($handle) {
		while(!feof($handle)) {
			$buffer = fgets($handle, 4096);
			list($file, $comment, $date, $owner) = split(":", $buffer, 4);
			$file = strtoupper($file);
			if($file != "" && $owner != "") {
				$catinfo[$file]["comment"] = $comment;
				$catinfo[$file]["date"] = $date;
				$catinfo[$file]["owner"] = $owner;
			}
		}
		fclose($handle);
		return $catinfo;
	}
}

function getFileDate($filename) {

	return date("d/m/Y", filemtime($filename));
}

function FillBoxInfo(&$foto_items, $filename, $toolbar, $foto_desc) {

	global $max_size, $select_size, $desc_filename;

	$size = GetImageSize($filename);
	$ismovie = isMovie($filename);
	if($ismovie) {
		$reso = getFileSizeString($filename);
	} else {
		$reso = "$size[0]x$size[1]";
	}
	
	$limited_size = array();
	if(($max_size > 0) && (!$ismovie)) {
		// sacar tamaños proporcionales
		$newancho = $size[0];
		$newalto = $size[1];
		if ($newancho > $newalto) {
			// ancho > alto
			if($newancho > $max_size) {
				$newancho = $max_size;
				$newalto = (int) ($size[0] * $newancho / $size[1]);
			}
		} else {
			// alto >= ancho
			if($newalto > $max_size) {
				$newalto = $max_size;
				$newancho = (int) ($size[1] * $newalto / $size[0]);
			}
		}
		$limited_size=array("width" => $newancho, "height" => $newalto);
	}
	$selectable_size=array();
	$sel_qty = 0;
	if(($select_size == 1) && (!$ismovie)) {
		$maximos = array(640, 800, 1024);
		for($i = 0; $i < count($maximos); $i++) {
			// sacar tamaños proporcionales
			$newancho = $size[0];
			$newalto = $size[1];
			if ($newancho > $newalto) {
				// ancho > alto
				if($newancho > $maximos[$i]) {
					$newancho = $maximos[$i];
					$newalto = (int) ($size[1] * $newancho / $size[0]);
				} else {
					break;
				}
			} else {
				// alto >= ancho
				if($newalto > $maximos[$i]) {
					$newalto = $maximos[$i];
					$newancho = (int) ($size[0] * $newalto / $size[1]);
				} else {
					break;
				}
			}
			$selectable_size[$newancho . "x" . $newalto]=array("width" => $newancho, "height" => $newalto);
		}
		$sel_qty = $i;
	}
	$date = getFileDate($filename);
	$desc = "";
	if($desc_filename) {
		$desc = fileNameToDesc($filename);
	}
	if($foto_desc != "") {
		$desc = $foto_desc;
	}
	$foto_items[$filename] = array(
		"ismovie" => $ismovie,
		"reso" => $reso, 
		"limited_size" => $limited_size, 
		"selectable_size" => $selectable_size, 
		"sel_qty" => $sel_qty, 
		"date" => $date, 
		"desc" => $desc, 
		"file_name" => strtoupper(getFileName($filename)), 
		"level" => 100);
}

function fileNameToDesc($filename) {

	$ret = $filename;
	
	// remove extension
	$ext = strrchr($ret, '.'); 
	if($ext !== false)  { 
		$ret = substr($ret, 0, -strlen($ext)); 
	}
	// remove path
	$slash = strrchr($ret, '/'); 
	if($slash !== false)  { 
		$ret = substr($ret, strlen($ret)-strlen($slash)+1); 
	}
	return $ret;
}

function getFileName($filename) {

	$ret = $filename;

	// remove path
	$slash = strrchr($ret, '/'); 
	if($slash !== false)  { 
		$ret = substr($ret, strlen($ret)-strlen($slash)+1); 
	}
	return $ret;
}

function printError($msg) {

	echo "\n<font face='verdana' size='1' color='#ff0000'>$msg</font>\n";
}

function printSuccess($msg) {

	echo "\n<font face='verdana' size='1' color='#009900'>$msg</font>\n";
}

function getNumberOfCat($level) {
	
	global $dir_base;

	$ret = 0;
	$dirtoread = $dir_base . $level . "/";
	if (is_dir($dirtoread)) {
	    if ($dh = opendir($dirtoread)) {
	        while (($file = readdir($dh)) !== false) {
		        if (is_dir($dirtoread . $file) && (!inIgnoreList($file))  ) {
		        	$ret++;
	        	}
	        }
	        closedir($dh);
	    }
	}
	return $ret;
}

function getNumberOfFotos($level) {

	global $dir_base;
	
	$ret = 0;
	$dirtoread = $dir_base . $level . "/";
	if (is_dir($dirtoread)) {
	    if ($dh = opendir($dirtoread)) {
	        while (($file = readdir($dh)) !== false) {
		        if ((is_file($dirtoread . $file)) && (substr($file, 0, 1) != ".") && (!inIgnoreList($file))  && (inAcceptList($file))  ) {
		        	$ret++;
	        	}
	        }
	        closedir($dh);
	    }
	}
	return $ret;
}

function getLinkPath($catid) {

	$cadlink = "<font class='xx-normal'><a href='javascript:changeCat(\"\")'>Indice/</a>";
	$sublink = "";

	$dirs = explode('/', $catid);
	$cur = "";
	for($y = 0; $y < (count($dirs) - 1); $y++) {
		if ($dirs[$y] != "") {
			$sublink = $sublink . "<a href='javascript:changeCat(\"" . $cur . $dirs[$y] . "\")'>" . $dirs[$y] . "/</a>";
		}
		$cur = $cur . $dirs[$y] . "/";
	}
	$sublink = $sublink . $dirs[$y];
	
	if($sublink != "") {
		$cadlink = $cadlink . "<a>" . $sublink . "</a>";
	}
	$cadlink = $cadlink . "</font>";
	return $cadlink;
}

function inAcceptList($file) {

	global $accept;
	
	for($y = 0; $y < count($accept); $y++) {
		if(strtoupper($accept[$y]) == substr(strtoupper($file),-3)) {
			return true;
		}
	}
	return false;
}

function inIgnoreList($file) {

	global $ignore;
	
	for($y = 0; $y < count($ignore); $y++) {
		if(strtoupper($ignore[$y]) == strtoupper($file)) {
			return true;
		}
	}
	return false;
}

function isMovie($filename) {

	global $movie_ext;
	
	$ext = strrchr($filename, '.');

	if($ext !== false)  { 
		$extname = substr($filename, strlen($filename)-strlen($ext)+1);
	} else {
		return false;
	}
	for($y = 0; $y < count($movie_ext); $y++) {
		if(strtoupper($movie_ext[$y]) == strtoupper($extname)) {
			return true;
		}
	}
	return false;
}

function getFileSizeString($file) {

	// find the filesize of the file
	$get_file_size = filesize($file);

	if (strlen($get_file_size) <= 9 && strlen($get_file_size) >= 7) {
		// if the filesize has between 7 an 9 characters then its in Mb
		$get_file_size = number_format($get_file_size / 1048576,1);
		return "$get_file_size MB";
	} elseif (strlen($get_file_size) >= 10) {
		// 10 characters or over means Gb
		$get_file_size = number_format($get_file_size / 1073741824,1);
		return "$get_file_size GB";
	} else {
		// anything else is kilobytes
		$get_file_size = number_format($get_file_size / 1024,1);
		return "$get_file_size KB";
	}
}

function getVar($name, $default) {
	if(isset($_GET[$name])) {
		return $_GET[$name]; 
	}
	return $default;
}

global $nombre_sitio, $ancho_sitio;

// index info
$smarty = array();
$smarty["site_name"] = $nombre_sitio;
$smarty["site_width"] = $ancho_sitio;

// footer info
$smarty["copyright"] = "© Todos los derechos reservados";
$smarty["email"] = "info@fotosparaver.com.ar";

//include "body.php";

global $dir_base, $max_pages, $max_size, $select_size, $desc_filename, $counter;

if(isset($_GET['image'])) {
	// Read vars/
	$image = getVar("image", "");
	$ancho = getVar("ancho", 200);
	$alto = getVar("alto", 200);
	$color = getVar("color", "ffffff");
	$usecache = getVar("usecache", 1);
	$nodump = getVar("nodump", 0);
	
	if(!isMovie($image)) {
		// Sets filename for cache
		$path_info = pathinfo($image);
		$cache_path = $cache_dir .  substr($path_info['dirname'], strlen($dir_base));
		if(!file_exists($cache_path)) {
			mkdir($cache_path,"0755",true);
		}
		$file_in_cache = $cache_path ."/". $path_info['basename'];
	} else {
		$usecache = 0;
		$image = $movie_image;
		$file_in_cache = $movie_image;
	}
	
	// Checks if the file in cache older than the original file (if the original is still uploading)
	clearstatcache();
	if ($usecache && file_exists($file_in_cache)) {
	
		if (filemtime($file_in_cache)<filemtime($image)) 
		    unlink($file_in_cache);
		    
		/*
		$difference_days = 0;
		for ($x = filemtime($file_in_cache); $x <= time(); $x += 86400) {
			$difference_days += 1;
		}
		if ($difference_days > $cache_image_max_days AND $cache_image_max_days != '0') { unlink($file_in_cache); }
		*/
	}
	

	// If file doesn't exists in cache, creates it
	if (!$usecache || !file_exists($file_in_cache)) {
		// Resize
		$im = imagecreatefromjpeg($image);
		$sx = imagesx($im);
		$sy = imagesy($im);

		if ($sx < $sy) {
			$dest_y = $ancho;
			$dest_x = $sx * $ancho / $sy;
		} else {
			$dest_x = $alto;
			$dest_y = $sy * $alto / $sx;
		}
	
		// Get the dimensions of the source picture
		$picsize = getimagesize("$image");
		$source_x  = $picsize[0];
		$source_y  = $picsize[1];
		$source_id = imageCreateFromJPEG("$image");
	
		// Create a new image object (not neccessarily true colour)
		$target_id = imagecreatetruecolor($dest_x, $dest_y);
	
		/* Resize the original picture and copy it into the just created image
		   object. Because of the lack of space I had to wrap the parameters to 
		   several lines. I recommend putting them in one line in order keep your
		   code clean and readable */
		$target_pic = imagecopyresampled($target_id, $source_id, 0, 0, 0, 0, $dest_x, $dest_y, $source_x, $source_y);
		if($nodump == 0) {
			header('Content-type: image/jpeg');
		}
		if ($usecache) {
			imagejpeg($target_id, $file_in_cache);
		}
	}
	

	if($nodump == 0) {
		// Sends image in cache to the browser
		if($usecache) {
			imagejpeg(imageCreateFromJPEG($file_in_cache));
		} else {
			imagejpeg($target_id);
		}
	}
	exit;
}

$catid = "";
$maxfotos = 6;
$offset = 0;
$page = "index.php";
$order = 0;
$user = "";
$password = "";
$module = "index.php";
$edit = 0;

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
$module = "index.php";
// load current module
if(isset($_POST['module'])) {
	$module = $_POST['module'];
}
$source = "";

		$user_level = 50;

		// welcome label
		$smarty["catid"] = $catid;
		if($catid == "") {
			$smarty["title"] = "";
		} else {
			$smarty["title"] = "";
		}
		
		// sort items
		$smarty["order_options"] = array(
						0 => 'Fecha de archivo',
						1 => 'Fecha de archivo invertido',
						2 => 'Nombre de archivo',
						3 => 'Nombre de archivo invertido');
		
		if ( empty($order) )	   
   		  $smarty["order"] = $smarty["order_options"][0];
	        else
		  $smarty["order"] = $order;
		
		$order = $smarty["order"];
		
		// max foto items
		$smarty["maxfotos_options"] = array(
						3 => '3',
						6 => '6',
						12 => '12',
						16 => '16');
		$smarty["maxfotos"] = $maxfotos;
		$cant_fotos = getNumberOfFotos($catid);
		$smarty["cant_fotos"] = $cant_fotos;
		$smarty["linked_path"] = getLinkPath($catid);
	
		// Recuadro de Categorías / Subcategorías
		$cant_cat = getNumberOfCat($catid);
		$smarty["cant_cat"] = $cant_cat;
	
		if ($catid == "") {
			$smarty["title_cat"] = "Categorías ($cant_cat)";
		} else {
			$smarty["title_cat"] = "Subcategorías ($cant_cat)";
		}
	
		if ($cant_cat > 0) {
			// Divido cat. en 2 columnas
			$porcol = round($cant_cat / 2);
			$dirtoread = $dir_base . $catid . "/";
			$filelist = array();
			if (is_dir($dirtoread)) {
			    if ($dh = opendir($dirtoread)) {
			        while (($file = readdir($dh)) !== false) {
				        if (is_dir($dirtoread . $file) && (!inIgnoreList($file)) ) {
				        	$filelist[$file]=$catid;
						}
			        }
			        closedir($dh);
			    }
			}
			switch (array_search($order, $smarty["order_options"])) {
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
			$smarty["porcol"] = $porcol;
			$smarty["cat_items"] = $cat_items;
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
			        if ((is_file($dirtoread . $file)) && (substr($file, 0, 1) != ".") && (!inIgnoreList($file)) && (inAcceptList($file))) {
						$filelist[$dirtoread . $file]=date("YmdHis", filemtime($dirtoread . $file));
					}
		        }
		        closedir($dh);
		    }
		}
		// anarko : aca modifique $order del switch por el array_search para que encuentre el orden
		switch (array_search($order, $smarty["order_options"])) {
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
		$smarty["edit"] = $edit;
		$smarty["perm_error"] = $perm_error;
		$smarty["user_level"] = $user_level;
		$smarty["desc_filename"] = $desc_filename;
		$smarty["select_size"] = $select_size;
		$smarty["max_size"] = $max_size;
		$smarty["maxx"] = $maxx;
		$smarty["foto_items"] = $foto_items;
		$smarty["user"] = $user;
		$smarty["counter"] = $counter;
	
		// Links a otras páginas, anterior y siguiente
		$offset = $offset - $maxfotos;
		$smarty["prev_offset"] = $offset;
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
		$smarty["nav_current"] = $offset + $maxfotos;
		$offset = $offset + ($maxfotos * 2);
		$smarty["next_offset"] = $offset;
		$smarty["nav_items"] = $nav_items;

		//$smarty["menu_items"] = array("indice" => "body.tpl", "logout" => "login.tpl", "cambiar contraseña" => "chgpsw.tpl", "registrarse" => "register.tpl");

echo "
<html>
<head>
<STYLE TYPE=\"text/css\" MEDIA=screen>
<!--
BODY {
	margin: 5;
	background: #FFFFFF ;
	}

UL {
	text-indent: 5;
	}
	
INPUT.text {
	border: solid #A0A0A0 ;
	border-width: 1 ;
	font-family: verdana,sans;
	Font-size: 10 ;
	color: #333333;
	}
	
SELECT {
	font-family: verdana,sans;
	Font-size: 10;
	}

TABLE.blanco1 {
	background: #ffffff ;
	border: solid #666666 ;
	border-width: 1 ;
	}

TABLE.gris1 {
	background: #eeeeee ;
	border: solid #666666 ;
	border-width: 1 ;
	}

TD.menu {
	cursor: pointer;
	}

A {
	font-family: verdana,sans;
	font-weight: bold ;
	font-size: 10 ;
	color: #666666 ;
	text-decoration: none
	}

A:hover {
	font-family: verdana,sans;
	font-weight: bold ;
	font-size: 10 ;
	color: #999999 ;
	text-decoration: none
	}

FONT.xx-normal {
	font-family: verdana,sans;
	font-weight: normal ;
	font-size: 10 ;
	color: #666666 ;
	}

FONT.xx-negrita {
	font-family: verdana,sans;
	font-weight: bold ;
	font-size: xx-small ;
	color: #666666 ;
	}

FONT.titulo {
	font-family: verdana,sans;
	color: #444444 ;
	font-size: 22;
	}
-->
</STYLE>
<title>" . $smarty["site_name"] . "</title>
</head>
<body>
<center>
<a name='arriba'></a>
<table class='cuerpo' width='" . $smarty["site_width"] . "' cellpadding='5' cellspacing='0' summary=''>
	<tr>
		<td valign='top' height='*'>
			<script language='JavaScript' type='text/javascript'>";
			// anarko : aca agregue \" a los changePage() en los parametros ncatid y norder pa ke no chille el puto java
			$navbar = "";
			if($smarty["prev_offset"] >= 0) {
				$navbar .= "<center><font class='xx-normal'><a href='javascript:changePage(\"" . $smarty["catid"] . "\", " . $smarty["prev_offset"] . ", " . $smarty["maxfotos"] . ", \"" . $smarty["order"] . "\", " . $smarty["edit"] . ")'>« Anterior</a>";
			} else {
				$navbar .= "<center><font class='xx-normal'>« Anterior";
			}
			$navbar .= "&nbsp;|"; 
			foreach ($smarty["nav_items"] as $nav_key => $nav_item) {
				if($smarty["nav_current"] == $nav_key) {
					$navbar .= "<font color='#FF0000'><b>" . $nav_item["num"] . "</b></font>|";
				} else { 
					$navbar .= "<a href='javascript:changePage(\"" . $smarty["catid"] . "\", " . $nav_item["from"] . ", " . $smarty["maxfotos"] . ", \"" . $smarty["order"] . "\", " . $smarty["edit"] . ")'>" . $nav_item["num"] . "</a>|";
				}
			}
			$navbar .= "&nbsp;";
			if($smarty["next_offset"] < $smarty["cant_fotos"]) {
				$navbar .= "<a href='javascript:changePage(\"" . $smarty["catid"] . "\", " . $smarty["next_offset"] . ", " . $smarty["maxfotos"] . ", \"" . $smarty["order"] . "\", " . $smarty["edit"] . ")'>Siguiente »</a></font></center>";
			//$navbar .= "<a href='javascript:changePage(null,16,16,1,0)'>Siguiente »</a></font></center>";
			} else {
				$navbar .= "Siguiente »</font></center>";
			}


			$navtitle = "<font class='xx-normal'><b>&nbsp;" . $smarty["linked_path"] . " (" . $smarty["cant_fotos"] . ")</b></font>";

			echo "
<!--
function changeCat(ncatid)
{
	document.form_indice.catid.value = ncatid;
	document.form_indice.submit();
}
function changePage(ncatid, noffset, nmaxfotos, norder, nedit)
{
	document.form_indice.catid.value = ncatid;
	document.form_indice.offset.value = noffset;
	document.form_indice.maxfotos.value = nmaxfotos;
	document.form_indice.order.value = norder;
	document.form_indice.edit.value = nedit;
	document.form_indice.submit();
}
//-->
</script>
<font class='titulo'>" . $smarty["title"] . "
</font>
<form method=POST action='index.php' name=form_indice>
<input type=hidden name=catid value=\"\">
<input type=hidden name=page value=\"index.php\">
<input type=hidden name=offset value=\"0\">
<input type=hidden name=edit value=\"0\">
<br>

<table width='100%' cellpadding='0' cellspacing='0' summary=''>
	<tr>
		<td align='right'> 
			<font class='xx-normal'>ordenar por :</font>
			<font class='xx-normal'>
				<select size='1' name=order onChange=\"javascript:changeCat('" . $smarty["catid"] . "')\">";
				foreach($smarty["order_options"] as $key => $value) {
					echo "<option value='$value'";
					// anarko : cambie $key en el if por $value para que quede seleccionado
					if($value == $smarty["order"]) {
						echo " selected";
					}
					echo ">$value</option>\n";
				}
				echo "</select>
			</font>
			<font class='xx-normal'>cantidad por página :</font>
			<font class='xx-normal'>
				<select size='1' name=maxfotos onChange=\"javascript:changeCat('" . $smarty["catid"] . "')\">";
				foreach($smarty["maxfotos_options"] as $key => $value) {
					echo "<option label=\"$key\" value=\"$value\"";
					if($key == $smarty["maxfotos"]) {
						echo " selected=\"selected\"";
					}
					echo ">$value</option>\n";
				}
				echo "</select>
			</font>
		</td>
	</tr>
</table>

<center>
<br>
<table class='gris1' width='100%' cellpadding='5' cellspacing='0' summary=''><tr><td><img src='images/folder-c.gif'>$navtitle</td></tr></table>
<br>
<table class='gris1' width='100%' cellpadding='5' cellspacing='0' summary=''>
	<tr>
		<td>
			<font class='xx-normal'>:: <b>" . $smarty["title_cat"] . "</b> ::</font>
			<hr noshade size='1' color='#666666'>
			<table width='100%' cellpadding='0' cellspacing='0' summary=''>
				<tr>";
				if($smarty["cant_cat"] > 0) {
					echo "<td width='50%' valign='top'>";
					$cont = 0;
					foreach($smarty["cat_items"] as $cat_file => $cant_cat) {
						echo "<img src='images/folder-c.gif' alt='$cat_file'>&nbsp;<a href=\"javascript:changeCat('" . $smarty["catid"] . "/$cat_file')\">$cat_file ($cant_cat)</a><br>";
						if($cont == $smarty["porcol"]) {
							echo "</td>
					<td width='50%' valign='top'>";
						}
						$cont++;
					}
					echo "</td>";
				} else {
					echo "<font class='xx-normal'>No hay subcategorías</font>";
				}
				echo "</tr>
			</table>
		</td>
	</tr>
</table>

<br>
<table class='gris1' width='100%' cellpadding='5' cellspacing='0' summary=''>";
if($smarty["perm_error"] != "0") {
	echo "
	<tr>
		<td width='100%' align='center' colspan=2><font face='verdana' size='1' color='#FF0000'>El directorio de esta categoría no tiene permisos suficientes para editar</font></td>
	</tr>";
}
echo "	<tr>
		<td>";
			if($smarty["cant_fotos"] > 0) {
			echo $navbar;
			echo "
			<hr noshade size='1' color='#666666'>
			<table width='100%' cellpadding='0' cellspacing='5' summary=''>
				<tr>";
			$contit = 0;
			foreach($smarty["foto_items"] as $foto_id => $foto_item) {
					echo "<td width='33%' valign='top' align='center'>
						<table width='100%' class='blanco1' summary=''>
							<tr>
								<td valign='top'>
									<center>
									<table width='200' height='200' cellpadding='0' cellspacing='0' summary=''>
									    <tr>
										<td valign='middle' align='center'>";
											//if($smarty["max_size"] <= 0 || $smarty["ismovie"]) {
											if($foto_item["ismovie"]=="ismovie") {
												echo "<a href='viewer.php?type=v&file=$foto_id' target='_blank'><img src='images/movie.jpg' width=150px border='0' alt='$foto_id'></a>";
											} else {
												echo "<a href='viewer.php?type=i&file=$foto_id' target='_blank'><img src='index.php?image=$foto_id&amp;ancho=200&amp;alto=200&amp;color=ffffff' border='0' alt='$foto_id'></a>";
												//echo "<a href='index.php?image=$foto_id&amp;ancho=" . $foto_item["limited_size"]["width"] . "&amp;alto=" . $foto_item["limited_size"]["height"] . "&amp;color=ffffff' target='_blank'><img src='index.php?image=$foto_id&amp;ancho=200&amp;alto=200&amp;usecache=0&amp;color=ffffff' border='0' alt='$foto_id'></a>";
											}
										echo "</td>
									    </tr>
									</table>
									</center>
									<hr noshade color='#666666' size='1'>
									<table cellpadding='0' cellspacing='0' summary=''>
									    <tr>";
									    $cont = 0;
										foreach($foto_item["selectable_size"] as $selsize_id => $selsize_item) {
											$cont++;
											echo "<td valign='middle' align='center'>
										<a href='index.php?image=$foto_id&amp;ancho=" . $selsize_item["width"] . "&amp;alto=" . $selsize_item["height"] . "&amp;usecache=0&amp;color=ffffff' target='_blank'><img border='0' src='images/size_$cont.gif' alt='$selsize_id'></a>&nbsp;
										</td>";
										}
										echo "</td>
									</table>
									<font class='xx-negrita'>" . $foto_item["date"];
									if($smarty["edit"] != 1) {
										if($foto_item["desc"] != "") {
										echo " - " . $foto_item["desc"];
										}
									} else {
										echo "<br>
										<table cellpadding='0' cellspacing='0' summary=''>
										    <tr>
												<td valign='middle' align='center'><font class='xx-normal'>Desc:&nbsp;</font></td>
												<td><input class='text' type='text' name='desc_" . $foto_item["file_name"] . "' size='40' value='" . $foto_item["desc"] . "'></td>
											</tr>
										</table>";
									}
									echo "</font>
									<font class='xx-normal'>(" . $foto_item["reso"] . ")</font><br>
								</td>
							</tr>
						</table>
					</td>";
					$contit++;
					if($contit != $maxfotos && ( $contit % $maxx == 0 ) ) {
				echo "</tr>
				<tr>";
					}
				}
				echo "</tr>
			</table>
			<hr noshade size='1' color='#666666'>
			$navbar";
			} else {
			echo "<font class='xx-normal'>No hay imágenes</font>";
			}
		echo "</td>
	</tr>
</table>
</form>
<BR><a href='#arriba'>:: Ir arriba ::</a>
</center>
		</td>
	</tr>
</table>
</center>
</body>
</html>";

?>
