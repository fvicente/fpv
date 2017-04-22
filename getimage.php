<?php
/**********************************************************************
Copyright (c) 2003, 2005 Alfer Soft Corp.
All rights reserved.
License available at
http://www.alfersoft.com.ar/fpv/license.html

Alfredo Vicente <avicente@ciudad.com.ar>
Fernando Vicente <fvicente@ciudad.com.ar>
**********************************************************************/

require_once "getimagefunc.php";

include ('config.php');

global $dir_base, $movie_image;

// Read vars
$image = getVar("image", "");
$ancho = getVar("ancho", 200);
$alto = getVar("alto", 200);
$color = getVar("color", "ffffff");
$usecache = getVar("usecache", 1);
$nodump = getVar("nodump", 0);

if(!isMovie($image)) {
	// Sets filename for cache
	$path_info = pathinfo($image);
	$cache_path = $cache_dir . "/" . substr($path_info['dirname'], strlen($dir_base));
	if(!file_exists($cache_path)) {
		mkdir($cache_path, 0777);
	}
	$file_in_cache = $cache_path ."/". $path_info['basename'];
} else {
	$usecache = 0;
	$image = $movie_image;
	$file_in_cache = $movie_image;
}

// Checks if the file in cache is too old
clearstatcache();
if ($usecache && file_exists($file_in_cache)) {
	$difference_days = 0;
	for ($x = filemtime($file_in_cache); $x <= time(); $x += 86400) {
		$difference_days += 1;
	}
	if ($difference_days > $cache_image_max_days AND $cache_image_max_days != '0') { unlink($file_in_cache); }
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

?>