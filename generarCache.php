#!/usr/bin/php
<?

$movie_ext = array("wmv", "mov", "avi", "mpg", "mpeg");


function rec_dirList($dir)
{
 if ($gestor = opendir($dir)) 
   {
    while (false !== ($archivo = readdir($gestor)))  
      {
       if ($archivo != "." && $archivo != "..") 
         { 
	  if ( is_dir("$dir/$archivo"))
            {    
	     $cacheDir = str_replace("files","cache","$dir/$archivo");
	     if ( !file_exists($cacheDir) )
  	        mkdir($cacheDir,"0755",true);
  	     rec_dirList($dir."/".$archivo);
	    }
	  else
	   {
	    echo "Redimensionando  : "."$dir/$archivo";
	    $cacheDir = str_replace("files","cache",$dir);
//            $ret = createResizedFile("$dir/$archivo");
	    if ( $ret == 0 ) 
	       echo "    [ OK ]\n";
	    if ( $ret == -1 )
	       echo "    [ Movie ]\n";
	    if ( $ret == -2 )
	       echo "    [ Size ]\n";	   
	    echo "Creando cache de : "."$dir/$archivo";	       
            $ret = createFileCache("$dir/$archivo","$cacheDir/$archivo");
	    if ( $ret == 0 ) 
	       echo "    [ OK ]\n";
	    if ( $ret == -1 )
	       echo "    [ Movie ]\n";
	    if ( $ret == -2 )
	       echo "    [ Size ]\n";	   
	   }
	 }
       }
     closedir($gestor);
  }
}

function createFileCache($image,$cacheImage)
{
    if ( isMovie($image) )
      return -1;
    if ( is_file($cacheImage))
      return 0;
    // Resize
    $im = imagecreatefromjpeg($image);
    $sx = imagesx($im);
    $sy = imagesy($im);
    $ancho = 200;
    $alto  = 200;
    
    if ($sx < $sy) {
        $dest_y = $ancho;
        $dest_x = $sx * $ancho / $sy;
    } else {
        $dest_x = $ancho;
        $dest_y = $sy * $ancho / $sx;
    }
																									
    // Get the dimensions of the source picture
    $picsize = getimagesize("$image");
    $source_x  = $picsize[0];
    $source_y  = $picsize[1];

    $source_id = imageCreateFromJPEG("$image");
    $target_id = imagecreatetruecolor($dest_x, $dest_y);
    $target_pic = imagecopyresampled($target_id, $source_id, 0, 0, 0, 0, $dest_x, $dest_y, $source_x, $source_y);
    imagejpeg($target_id, $cacheImage);
    return 0;
}

function createResizedFile($image)
{
    if ( isMovie($image) )
      return -1;

    $ancho = 1024;
    $alto  = 768;

    $tmp_image = $image."_tmp";
    // Resize
    $im = imagecreatefromjpeg($image);
    $sx = imagesx($im);
    $sy = imagesy($im);

    if ( $sx <= $ancho )
      return -2;
      
    if ( $sy <= $alto )
      return -2;

    
    if ($sx < $sy) {
        $dest_y = $ancho;
        $dest_x = $sx * $ancho / $sy;
    } else {
        $dest_x = $ancho;
        $dest_y = $sy * $ancho / $sx;
    }
																									
    // Get the dimensions of the source picture
    $picsize = getimagesize("$image");
    $source_x  = $picsize[0];
    $source_y  = $picsize[1];

    $source_id = imageCreateFromJPEG("$image");
    $target_id = imagecreatetruecolor($dest_x, $dest_y);
    $target_pic = imagecopyresampled($target_id, $source_id, 0, 0, 0, 0, $dest_x, $dest_y, $source_x, $source_y);
    imagejpeg($target_id, $tmp_image);
    unlink($image);
    rename($tmp_image,$image);
    return 0;
}


function isMovie($filename) 
{
 global $movie_ext;
 $ext = strrchr($filename, '.');
 
 if ($ext !== false)  
   $extname = substr($filename, strlen($filename)-strlen($ext)+1);
 else 
   return false;

 for ($y = 0; $y < count($movie_ext); $y++) 
    if (strtoupper($movie_ext[$y]) == strtoupper($extname)) 
      return true;

 return false;
}
																			


rec_dirList("files");




?>
