			<hr noshade color='#666666' size='1'>
			<table width='100%' cellpadding='0' cellspacing='0' summary=''>
				<tr>
					<td valign='top' align='left'>
						{if $user != ""}
						<font class='xx-normal'>Usu�rio: {$user}</font><br>
						{/if}
						{if $counter != ""}
						<font class='xx-normal'>Visitante n�mero: {$counter}</font>
						{/if}
					</td>
					<td valign='top' align='right'>
						<font class='xx-normal'>{$copyright}<br>
						Webmaster: <a href='mailto:{$email}'>{$email}</a></font>
					</td>
				</tr>
			</table>
