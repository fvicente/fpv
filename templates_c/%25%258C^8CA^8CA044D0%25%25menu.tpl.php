<?php /* Smarty version 2.6.9, created on 2005-08-24 19:27:00
         compiled from menu.tpl */ ?>
			<script language='JavaScript' type='text/javascript'>
<?php echo '
			<!--
			function menuClick(mod)
			{
				document.form_menu.module.value = mod;
				document.form_menu.submit();
			}
			//-->
'; ?>

			</script>
			<form method=POST action='index.php' name=form_menu>
			<input type=hidden name=module value="body.tpl">
			<table cellpadding='4' cellspacing='0' summary=''>
				<tr>
					<td><font class='xx-normal'>::</font></td>
<?php $_from = $this->_tpl_vars['menu_items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['menu_name'] => $this->_tpl_vars['menu_page']):
?>
					<td align='center' valign='middle' class='menu' bgColor='#FFFFFF' onmouseover=\"bgColor='#DDDDDD'\" onmouseout="bgColor='#FFFFFF'" onclick='javascript:menuClick("<?php echo $this->_tpl_vars['menu_page']; ?>
")'><font class='xx-negrita'><?php echo $this->_tpl_vars['menu_name']; ?>
</font></td><td><font class='xx-normal'>::</font></td>
<?php endforeach; endif; unset($_from); ?>
				</tr>
			</table>
			</form>