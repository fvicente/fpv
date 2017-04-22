<?php /* Smarty version 2.6.9, created on 2005-08-25 11:05:40
         compiled from resetpsw.tpl */ ?>
	<br><br>
	<center>
	<form method=post>
		<input type=hidden name=action value="resetpsw">
		<input type=hidden name=module value="resetpsw.tpl">
		<table class='gris1' width='400' cellpadding='5' cellspacing='0'>
			<tr>
				<td width='100%'>
					<font class='xx-normal'>:: <b>Crear nueva password</b> ::</font>
					<hr noshade size='1' color='#666666'>
						<table width='100%' cellpadding='3' cellspacing='0'>
<?php if ($this->_tpl_vars['error'] != ""): ?>
							<tr>
								<td width='100%' align='center' colspan=2><font face='verdana' size='1' color='#FF0000'><?php echo $this->_tpl_vars['error']; ?>
</font></td>
							</tr>
<?php endif; ?>
							<tr>
								<td width='50%' align='right'><font class='xx-normal'>Usuario</font></td><td width='50%'><input class='text' type='text' name='user1' size='40'></td>
							</tr>
							<tr>
								<td width='50%' align='right'><font class='xx-normal'>Dirección de e-mail</font></td><td width='50%'><input class='text' type='text' name='email' size='40'></td>
							</tr>
							<tr>
								<td width='100%' align='center' colspan=2>
								<hr noshade size='1' color='#666666'>
								<font class='xx-normal'>Atención! enviaremos un e-mail a su cuenta para confirmar que quiere crear una nueva password. Por favor ingrese su usuario y e-mail y presione 'crear password' para confirmar</font><br>
								<hr noshade size='1' color='#666666'>
								</td>
							</tr>
							<tr>
								<td width='100%' align='center' colspan=2><input class='text' type='submit' name=resetpsw value='crear password'><br></td>
							</tr>
						</table>
				</td>
		</table>
	</form>
	</center>
	<br><br>