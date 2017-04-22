<?php /* Smarty version 2.6.9, created on 2005-08-30 15:00:05
         compiled from register.tpl */ ?>
	<br><br>
	<center>
<?php if ($this->_tpl_vars['action'] == 'register'): ?>
	<table class='gris1' width='400' cellpadding='5' cellspacing='0'>
		<tr>
			<td width='100%'>
				<font class='xx-normal'>:: <b>Confirmación enviada</b> ::</font>
				<hr noshade size='1' color='#666666'>
					<table width='100%' cellpadding='3' cellspacing='0'>
						<tr>
							<td width='100%' align='center'><font class='xx-normal'>Un e-mail a sido enviado a <?php echo $this->_tpl_vars['email']; ?>
 con una contraseña temporal.<br>Por favor verifique su casilla en unos minutos.</font></td>
						</tr>
					</table>
			</td>
	</table>
<?php else: ?>
	<form method=post>
		<input type=hidden name=action value="register">
		<input type=hidden name=module value="register.tpl">
		<table class='gris1' width='400' cellpadding='5' cellspacing='0'>
			<tr>
				<td width='100%'>
					<font class='xx-normal'>:: <b>Registrarse</b> ::</font>
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
								<font class='xx-normal'>Atención! enviaremos un e-mail a su cuenta con una contraseña temporal.</font><br>
								<hr noshade size='1' color='#666666'>
								</td>
							</tr>
							<tr>
								<td width='100%' align='center' colspan=2><input class='text' type='submit' name=register value=registrarse><br></td>
							</tr>
						</table>
				</td>
		</table>
	</form>
<?php endif; ?>
	</center>
	<br><br>