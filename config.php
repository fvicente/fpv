<?
/**********************************************************************
Copyright (c) 2003, 2005 Alfer Soft Corp.
All rights reserved.
License available at
http://www.alfersoft.com.ar/fpv/license.html

Alfredo Vicente <avicente@ciudad.com.ar>
Fernando Vicente <fvicente@ciudad.com.ar>
**********************************************************************/

$nombre_sitio = "fotos para ver - tus imagenes preferidas...";
$ancho_sitio = "700";

$dir_base = "files";			# directorio base para fotos no debe incluir "/"
$cache_dir = "cache";			# directorio base para cache no debe incluir "/"
$cache_image_max_days = "30";	# Si el valor es "0" la imagen no se renovar�
$max_size = 0;					# 0 = sin tama�o m�ximo. > 0 fuerza tama�o m�ximo (ancho o alto) cuando el usuario hace click en el thumb
$select_size = 1;				# 0 = no mostrar resoluciones menores. 1 = muestra resaoluciones predefinidas
$desc_filename = 1;				# 1 = usar nombre de archivo como descripci�n
$max_pages = 20;				# m�ximo de links para salto a otras p�ginas
$maxfotos = 6;
$ignore = array("thumbs.db", "cvs", ".", "..");
$movie_ext = array("wmv", "mov", "avi", "mpg", "mpeg");
$movie_image = "images/movie.jpg";
$fpv_path = getcwd();
$site_name = "fer.fotosparaver.com.ar";
$mail_admin = "admin@fotosparaver.com.ar";

setlocale(LC_ALL, "es_AR");
?>