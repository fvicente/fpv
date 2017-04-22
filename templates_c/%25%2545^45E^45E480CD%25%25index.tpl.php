<?php /* Smarty version 2.6.9, created on 2005-08-24 19:27:00
         compiled from index.tpl */ ?>
<html>
<head>
<LINK REL=StyleSheet HREF="stylesheet.css" TYPE="text/css">
<title><?php echo $this->_tpl_vars['site_name']; ?>
</title>
</head>
<body>
<center>
<table class='cuerpo' width='<?php echo $this->_tpl_vars['site_width']; ?>
' cellpadding='5' cellspacing='0' summary=''>
	<tr>
		<td valign='top'>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</td>
	</tr>
	<tr>
		<td valign='top' align='right'>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</td>
	</tr>
	<tr>
		<td valign='top' height='*'>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['module'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</td>
	</tr>
	<tr>
		<td valign='top'>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</td>
	</tr>
</table>
</center>
</body>
</html>