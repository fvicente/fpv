<?php /* Smarty version 2.6.9, created on 2005-08-30 14:59:57
         compiled from login.tpl */ ?>
	<br><br>
	<center>
	<form method=post>
		<table class='gris1' width='400' cellpadding='5' cellspacing='0'>
			<tr>
				<td width='100%'>
					<font class='xx-normal'>:: <b>Ingreso de usuario</b> ::</font>
					<hr noshade size='1' color='#666666'>
					<table width='100%' cellpadding='3' cellspacing='0'>
<?php if ($this->_tpl_vars['error'] != ""): ?>
						<tr>
							<td width='100%' align='center' colspan=2><font face='verdana' size='1' color='#FF0000'><?php echo $this->_tpl_vars['error']; ?>
</font></td>
						</tr>
<?php endif; ?>
						<tr>
							<td width='50%' align='right'><font class='xx-normal'>Usuario</font></td><td width='50%'><input class='text' type='text' name='user' size='40'></td>
						</tr>
						<tr>
							<td width='50%' align='right'><font class='xx-normal'>Contraseña</font></td><td width='50%'><input class='text' type='password' name='password' size='40'></td>
						</tr>
						<tr>
							<td width='100%' colspan=2 align='right'>
								<hr noshade size='1' color='#666666'>
							</td>
						</tr>
						<tr>
							<td width='100%' align='center' colspan=2><input class='text' type='submit' name=login value=ingresar><br></td>
						</tr>
						<tr>
							<td width='100%' colspan=2 align='right'>
								<hr noshade size='1' color='#666666'>
								<font class='xx-normal'>¿No tiene una cuenta?</font>&nbsp;<a href='javascript:menuClick("register.tpl")'>Registrese.</a><br>
								<font class='xx-normal'>¿Olvidó su password?</font>&nbsp;<a href='javascript:menuClick("sendpsw.tpl")'>Recordármela.</a>
							</td>
						</tr>
					</table>
				</td>
		</table>
	</form>
	</center>
	<br><br>