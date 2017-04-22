	<br><br>
	<center>
{if $action == "sendpsw"}
	<table class='gris1' width='400' cellpadding='5' cellspacing='0'>
		<tr>
			<td width='100%'>
				<font class='xx-normal'>:: <b>Contraseña enviada</b> ::</font>
				<hr noshade size='1' color='#666666'>
					<table width='100%' cellpadding='3' cellspacing='0'>
						<tr>
							<td width='100%' align='center'><font class='xx-normal'>Un e-mail a sido enviado a {$email} con su contraseña.<br>Por favor verifique su casilla en unos minutos.</font></td>
						</tr>
					</table>
			</td>
	</table>
{else}
	<form method=post>
		<input type=hidden name=action value="sendpsw">
		<input type=hidden name=module value="sendpsw.tpl">
		<table class='gris1' width='400' cellpadding='5' cellspacing='0'>
			<tr>
				<td width='100%'>
					<font class='xx-normal'>:: <b>Enviar contraseña</b> ::</font>
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
								<td width='50%' align='right'><font class='xx-normal'>Dirección de e-mail</font></td><td width='50%'><input class='text' type='text' name='email' size='40'></td>
							</tr>
							<tr>
								<td width='100%' align='center' colspan=2>
								<hr noshade size='1' color='#666666'>
								<font class='xx-normal'>Atención! enviaremos un e-mail a su cuenta recordándole su contraseña. Por favor ingrese su usuario y e-mail y presione 'enviar contraseña' para confirmar</font><br>
								<hr noshade size='1' color='#666666'>
								</td>
							</tr>
							<tr>
								<td width='100%' align='center' colspan=2><input class='text' type='submit' name=sendpsw value='enviar contraseña'><br></td>
							</tr>
						</table>
				</td>
		</table>
	</form>
{/if}
	</center>
	<br><br>