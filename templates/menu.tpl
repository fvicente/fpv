			<script language='JavaScript' type='text/javascript'>
{literal}
			<!--
			function menuClick(mod)
			{
				document.form_menu.module.value = mod;
				document.form_menu.submit();
			}
			//-->
{/literal}
			</script>
			<form method=POST action='index.php' name=form_menu>
			<input type=hidden name=module value="body.tpl">
			<table cellpadding='4' cellspacing='0' summary=''>
				<tr>
					<td><font class='xx-normal'>::</font></td>
{foreach from=$menu_items key=menu_name item=menu_page}
					<td align='center' valign='middle' class='menu' bgColor='#FFFFFF' onmouseover=\"bgColor='#DDDDDD'\" onmouseout="bgColor='#FFFFFF'" onclick='javascript:menuClick("{$menu_page}")'><font class='xx-negrita'>{$menu_name}</font></td><td><font class='xx-normal'>::</font></td>
{/foreach}
				</tr>
			</table>
			</form>
