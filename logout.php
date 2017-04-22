<?php
/**********************************************************************
Copyright (c) 2003, 2005 Alfer Soft Corp.
All rights reserved.
License available at
http://www.alfersoft.com.ar/fpv/license.html

Alfredo Vicente <avicente@ciudad.com.ar>
Fernando Vicente <fvicente@ciudad.com.ar>
**********************************************************************/

session_start();
session_unset();
session_destroy();

setcookie("fpv_cookie_name");
setcookie("fpv_enc_pwd");

echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\">";

?>