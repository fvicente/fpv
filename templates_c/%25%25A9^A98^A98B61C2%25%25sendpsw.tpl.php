<?php /* Smarty version 2.6.9, created on 2005-08-25 11:32:41
         compiled from sendpsw.tpl */ ?>
	<br><br>
	<center>
<?php if ($this->_tpl_vars['action'] == 'sendpsw'): ?>
	<table class='gris1' width='400' cellpadding='5' cellspacing='0'>
		<tr>
			<td width='100%'>
				<font class='xx-normal'>:: <b>Contrase�a enviada</b> ::</font>
				<hr noshade size='1' color='#666666'>
					<table width='100%' cellpadding='3' cellspacing='0'>
						<tr>
							<td width='100%' align='center'><font class='xx-normal'>Un e-mail a sido enviado a <?php echo $this->_tpl_vars['email']; ?>
 con su contrase�a.<br>Por favor verifique su casilla en unos minutos.</font></td>
						</tr>
					</table>
			</td>
	</table>
<?php else: ?>
	<form method=post>
		<input type=hidden name=action value="sendpsw">
		<input type=hidden name=module value="sendpsw.tpl">
		<table class='gris1' width='400' cellpadding='5' cellspacing='0'>
			<tr>
				<td width='100%'>
					<font class='xx-normal'>:: <b>Enviar contrase�a</b> ::</font>
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
								<td width='50%' align='right'><font class='xx-normal'>Direcci�n de e-mail</font></td><td width='50%'><input class='text' type='text' name='email' size='40'></td>
							</tr>
							<tr>
								<td width='100%' align='center' colspan=2>
								<hr noshade size='1' color='#666666'>
								<font class='xx-normal'>Atenci�n! enviaremos un e-mail a su cuenta record�ndole su contrase�a. Por favor ingrese su usuario y e-mail y presione 'enviar contrase�a' para confirmar</font><br>
								<hr noshade size='1' color='#666666'>
								</td>
							</tr>
							<tr>
								<td width='100%' align='center' colspan=2><input class='text' type='submit' name=sendpsw value='enviar contrase�a'><br></td>
							</tr>
						</table>
				</td>
		</table>
	</form>
<?php endif; ?>
	</center>
	<br><br>