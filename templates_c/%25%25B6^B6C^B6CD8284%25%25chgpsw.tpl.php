<?php /* Smarty version 2.6.9, created on 2005-08-24 19:35:52
         compiled from chgpsw.tpl */ ?>
	<br><br>
	<center>
<?php if ($this->_tpl_vars['action'] == 'chgpsw'): ?>
	<table class='gris1' width='400' cellpadding='5' cellspacing='0'>
		<tr>
			<td width='100%'>
				<font class='xx-normal'>:: <b>Contrase�a cambiada</b> ::</font>
				<hr noshade size='1' color='#666666'>
					<table width='100%' cellpadding='3' cellspacing='0'>
						<tr>
							<td width='100%' align='center'><font class='xx-normal'>La contrase�a ha sido cambiada con exito.</font></td>
						</tr>
					</table>
			</td>
	</table>
<?php else: ?>
	<form method=post>
		<input type=hidden name=action value="chgpsw">
		<input type=hidden name=module value="chgpsw.tpl">
		<table class='gris1' width='400' cellpadding='5' cellspacing='0'>
			<tr>
				<td width='100%'>
					<font class='xx-normal'>:: <b>Cambio de password</b> ::</font>
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
								<td width='50%' align='right'><font class='xx-normal'>Contrase�a antigua</font></td><td width='50%'><input class='text' type='password' name='password1' size='40'></td>
							</tr>
							<tr>
								<td width='50%' align='right'><font class='xx-normal'>Contrase�a nueva</font></td><td width='50%'><input class='text' type='password' name='newpsw1' size='40'></td>
							</tr>
							<tr>
								<td width='50%' align='right'><font class='xx-normal'>Repetir contrase�a nueva</font></td><td width='50%'><input class='text' type='password' name='newpsw2' size='40'></td>
							</tr>
							<tr>
								<td width='100%' colspan=2 align='right'>
									<hr noshade size='1' color='#666666'>
								</td>
							</tr>
							<tr>
								<td width='100%' align='center' colspan=2><input class='text' type='submit' name=chgpsw value=cambiar><br></td>
							</tr>
						</table>
				</td>
		</table>
	</form>
<?php endif; ?>
	</center>
	<br><br>