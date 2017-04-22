	<br><br>
	<center>
{if $action == "chgpsw"}
	<table class='gris1' width='400' cellpadding='5' cellspacing='0'>
		<tr>
			<td width='100%'>
				<font class='xx-normal'>:: <b>Contraseña cambiada</b> ::</font>
				<hr noshade size='1' color='#666666'>
					<table width='100%' cellpadding='3' cellspacing='0'>
						<tr>
							<td width='100%' align='center'><font class='xx-normal'>La contraseña ha sido cambiada con exito.</font></td>
						</tr>
					</table>
			</td>
	</table>
{else}
	<form method=post>
		<input type=hidden name=action value="chgpsw">
		<input type=hidden name=module value="chgpsw.tpl">
		<table class='gris1' width='400' cellpadding='5' cellspacing='0'>
			<tr>
				<td width='100%'>
					<font class='xx-normal'>:: <b>Cambio de password</b> ::</font>
					<hr noshade size='1' color='#666666'>
						<table width='100%' cellpadding='3' cellspacing='0'>
{if $error != ""}
							<tr>
								<td width='100%' align='center' colspan=2><font face='verdana' size='1' color='#FF0000'>{$error}</font></td>
							</tr>
{/if}
							<tr>
								<td width='50%' align='right'><font class='xx-normal'>Usuario</font></td><td width='50%'><input class='text' type='text' name='user1' size='40'></td>
							</tr>
							<tr>
								<td width='50%' align='right'><font class='xx-normal'>Contraseña antigua</font></td><td width='50%'><input class='text' type='password' name='password1' size='40'></td>
							</tr>
							<tr>
								<td width='50%' align='right'><font class='xx-normal'>Contraseña nueva</font></td><td width='50%'><input class='text' type='password' name='newpsw1' size='40'></td>
							</tr>
							<tr>
								<td width='50%' align='right'><font class='xx-normal'>Repetir contraseña nueva</font></td><td width='50%'><input class='text' type='password' name='newpsw2' size='40'></td>
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
{/if}
	</center>
	<br><br>