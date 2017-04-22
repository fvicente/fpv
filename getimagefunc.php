<?
/**********************************************************************
Copyright (c) 2003, 2005 Alfer Soft Corp.
All rights reserved.
License available at
http://www.alfersoft.com.ar/fpv/license.html

Alfredo Vicente <avicente@ciudad.com.ar>
Fernando Vicente <fvicente@ciudad.com.ar>
**********************************************************************/

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

function getVar($name, $default) {
	if(isset($_GET[$name])) {
		return $_GET[$name]; 
	}
	return $default;
}

?>