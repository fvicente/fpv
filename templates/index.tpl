<html>
<head>
<LINK REL=StyleSheet HREF="stylesheet.css" TYPE="text/css">
<title>{$site_name}</title>
</head>
<body>
<center>
<table class='cuerpo' width='{$site_width}' cellpadding='5' cellspacing='0' summary=''>
	<tr>
		<td valign='top'>
{include file="header.tpl"}
		</td>
	</tr>
	<tr>
		<td valign='top' align='right'>
{include file="menu.tpl"}
		</td>
	</tr>
	<tr>
		<td valign='top' height='*'>
{include file=$module}
		</td>
	</tr>
	<tr>
		<td valign='top'>
{include file="footer.tpl"}
		</td>
	</tr>
</table>
</center>
</body>
</html>
