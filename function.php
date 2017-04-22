<?
/**********************************************************************
Copyright (c) 2003, 2005 Alfer Soft Corp.
All rights reserved.
License available at
http://www.alfersoft.com.ar/fpv/license.html

Alfredo Vicente <avicente@ciudad.com.ar>
Fernando Vicente <fvicente@ciudad.com.ar>
**********************************************************************/

global $counter;

session_start();

$counter = getCounter();

function increaseAndGetCounter() {
	
	global $counter;
	
	$cnt = getCounter();
	$cnt = $cnt + 1;
	writeCounter($cnt);
	$counter = $cnt;

	return $cnt;
}

function writeCounter($value) {

	$handle = @fopen(".counter.php", "w+");
	if($handle) {
		fwrite($handle, "<?php");
		fwrite($handle, "\n/*");
		fwrite($handle, "\n$value");
		fwrite($handle, "\n*/");
		fwrite($handle, "\n?>");
		fclose($handle);
	}
}

function getCounter() {

	$handle = @fopen(".counter.php", "r");
	if($handle) {
		$buffer = fgets($handle, 4096); // <?php
		$buffer = fgets($handle, 4096); // /*
		$buffer = fgets($handle, 4096); // counter value
		fclose($handle);
		return $buffer;
	}
	return 0;
}

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

function saveUserFile() {

	global $users;

	$handle = fopen(".users.php", "w+");
	fwrite($handle, "<?php");
	fwrite($handle, "\n/*");
	foreach($users as $key => $value) {
		if(isset($users[$key])) {
			$pass = $users[$key]["password"];
			$email = $users[$key]["email"];
			$level = $users[$key]["level"];
			fwrite($handle, "\n$key:$pass:$email:$level");
		}
	}
	fwrite($handle, "\n*/");
	fwrite($handle, "\n?>");
	fclose($handle);
}

function changePsw($user, $password, $newpsw1) {

	global $users;

	if(isset($users[$user]["password"])) {
		$users[$user]["password"] = $newpsw1;
		saveUserFile();
	}
}

function checkUser($user, $password) {

	global $users;

	$ret = false;
	if(isset($users[$user]["password"])) {
		$ret = (md5($users[$user]["password"]) == $password);
	}
	return $ret;
}

function getCookieInfo() {

	// No está logueado, intentar loguearse si existe cookie
	if (isset($_COOKIE["fpv_cookie_name"]) && isset($_COOKIE["fpv_enc_pwd"])) {
		if(checkUser($_COOKIE["fpv_cookie_name"], $_COOKIE["fpv_enc_pwd"])) {
			$_SESSION['cookie_name'] = $_COOKIE["fpv_cookie_name"];
			$_SESSION['enc_pwd'] = $_COOKIE["fpv_enc_pwd"];
		}
	}
}

function setCookieInfo() {

	$setcook = 0;
	if(isset($_SESSION['cookie_name']) && isset($_SESSION['enc_pwd'])) {
		$setcook = 1;
	}
	if($setcook == 1) {
		setcookie("fpv_cookie_name", $_SESSION['cookie_name'], time() + (60 * 60 * 24 * 30), '', '', 0);
		setcookie("fpv_enc_pwd", $_SESSION['enc_pwd'], time() + (60 * 60 * 24 * 30), '', '', 0);
	}
}

function getUserLevel($user) {
	
	global $users;
	
	return $users[$user]["level"];
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
	$foto_items[$filename] = array("ismovie" => $ismovie, "reso" => $reso, "limited_size" => $limited_size, "selectable_size" => $selectable_size, "sel_qty" => $sel_qty, "date" => $date, "desc" => $desc, "file_name" => strtoupper(getFileName($filename)), "level" => 100);
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
		        if (is_dir($dirtoread . $file) && (!inIgnoreList($file))) {
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
		        if ((is_file($dirtoread . $file)) && (substr($file, 0, 1) != ".") && (!inIgnoreList($file))) {
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

?>