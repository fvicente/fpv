<?php
/**********************************************************************
Copyright (c) 2003, 2005 Alfer Soft Corp.
All rights reserved.
License available at
http://www.alfersoft.com.ar/fpv/license.html

Alfredo Vicente <avicente@ciudad.com.ar>
Fernando Vicente <fvicente@ciudad.com.ar>
**********************************************************************/
?>
<html>
<body>
<?php

function getVar($name, $default) {
	if(isset($_GET[$name])) {
		return $_GET[$name]; 
	}
	return $default;
}
$image = getVar("image", "");
$ancho = getVar("ancho", 200);
$alto = getVar("alto", 200);
$color = getVar("color", "ffffff");

echo "	<img src='getimage.php?image=$image&ancho=$ancho&alto=$alto&color=$color&usecache=0' border='0'>";

?>
</body>
</html>