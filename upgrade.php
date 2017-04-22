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

$mysql_srv = "localhost";
$mysql_usr = "alfersoft";
$mysql_psw = "";
$mysql_db = "fpv";
$db = 0;
$base_oldfpv = "/var/www/webs/fotosparaver.com.ar/";

global $dir_base;

function getInfoField($info, $key, $default) {
	if(isset($info[$key])) {
		return $info[$key];
	} else {
		return $default;
	}
}

function saveCatInfoFile($cat, $info) {

	$tmpdir = $cat . "/";
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

function getPathCat($catid) {
	
	global $db, $base_oldfpv;
	
	$path = "files/";
	$subpath = "";	
	$query = "SELECT * FROM cat WHERE id=$catid";
	$res = @mysql_query($query, $db);
	if ($res) {
		if ($row = mysql_fetch_array($res)) {
			$subpath = "$catid";
			while ($row['parent'] > 0) {
				$query = "SELECT * FROM cat WHERE id=" . $row['parent'];
				$res = @mysql_query($query, $db);
				if ($res) {
					if ($row = mysql_fetch_array($res)) {
						$subpath = $row['id'] . "/" . $subpath;
					} else {
						break;
					}
				} else {
					break;
				}
			}
		}
	}
	$path = $base_oldfpv . $path . $subpath;
	return $path;

}

function getPath($catid) {
	
	global $db;
	
	$cadlink = "/";
	$sublink = "";
	$query = "SELECT * FROM cat WHERE id=$catid";
	$res = @mysql_query($query, $db);
	if ($res) {
		if ($row = mysql_fetch_array($res)) {
			$sublink = $row['descrip'] . $sublink;
			while ($row['parent'] > 0) {
				$query = "SELECT * FROM cat WHERE id=" . $row['parent'];
				$res = @mysql_query($query, $db);
				if ($res) {
					if ($row = mysql_fetch_array($res)) {
						$sublink = $row['descrip'] . "/" . $sublink;
					} else {
						break;
					}
				} else {
					break;
				}
			}
		}
	}
	$cadlink = $cadlink . $sublink;
	return $cadlink;
}

function AddCat($item, $clave) {
	global $dir_base, $db;
	mkdir($dir_base . $item);

	$catinfo = array();
	$dirtoread = getPathCat(trim($clave)) . "/";
	if(is_dir($dirtoread)) {
	    if($dh = opendir($dirtoread)) {
	        while(($file = readdir($dh)) !== false) {
		        if((is_file($dirtoread . $file)) && (substr($file, 0, 1) != ".")) {
		        	$query = "SELECT * FROM fotos WHERE cat=" . trim($clave) . " AND UCASE(file)=\"" . strtoupper(trim($file)) . "\"";
					$res = mysql_query($query, $db);
					if($res) {
						if($row = mysql_fetch_object($res)) {
							$catinfo[$file]["comment"] = $row->descrip;
							$catinfo[$file]["date"] = $row->foto_date;
							$catinfo[$file]["owner"] = $row->user;
						}
					}
					echo $dirtoread . $file . "->" . $dir_base . $item . $file . chr(13);
					copy($dirtoread . $file, $dir_base . $item . '/' . $file);
				}
	        }
	        closedir($dh);
	        saveCatInfoFile($dir_base . $item, $catinfo);
	    }
	}
}

ob_implicit_flush(1);
set_time_limit(0);

$db = mysql_connect($mysql_srv, $mysql_usr, $mysql_psw);
mysql_select_db($mysql_db, $db);
if (!$db) {
	echo "Error abriendo base de datos $mysql_db";
	exit;
}

$dir_base = "/tmp/upgrade";
$query = "SELECT * FROM cat";
$res = mysql_query($query, $db);
if($res) {
	$arrcat = array();
	while($row = mysql_fetch_object($res)) {
		$arrcat[' ' . $row->id] = getPath($row->id);
	}
	array_multisort($arrcat);
	array_walk($arrcat, 'AddCat');
}

?>