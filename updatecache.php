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

global $dir_base;

function inIgnoreList($file) {

	global $ignore;
	
	for($y = 0; $y < count($ignore); $y++) {
		if(strtoupper($ignore[$y]) == strtoupper($file)) {
			return true;
		}
	}
	return false;
}

function processCache($dirtoread) {

	if (is_dir($dirtoread)) {
	    if ($dh = opendir($dirtoread)) {
	        while (($file = readdir($dh)) !== false) {
		        if ((is_file($dirtoread . $file)) && (substr($file, 0, 1) != ".") && (!inIgnoreList($file))) {
		        	echo "processing " . $file . " <BR>\n";
		        	$_GET["image"] = $dirtoread . $file;
		        	$_GET["nodump"] = 1;
					include "getimage.php";
				} else {
					if ((is_dir($dirtoread . $file)) && (!inIgnoreList($file))) {
						echo "folder " . $dirtoread . $file . " <BR>\n";
			        	processCache($dirtoread . $file . "/");
					}
		        }
	        }
	        closedir($dh);
	    }
	}
}

ob_implicit_flush(1);
set_time_limit(0);
$filelist = array();
processCache($dir_base . "/");

?>