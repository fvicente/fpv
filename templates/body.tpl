<script language='JavaScript' type='text/javascript'>
{capture name=navbar}
			{if $prev_offset >= 0}
			<center><font class='xx-normal'><a href='javascript:changePage("{$catid}", {$prev_offset}, {$maxfotos}, {$order}, {$edit})'>« Anterior</a>
			{else}
			<center><font class='xx-normal'>« Anterior
			{/if}
&nbsp;|{foreach from=$nav_items key=nav_key item=nav_item name=navloop}
{if $nav_current == $nav_key}<font color='#FF0000'><b>{$nav_item.num}</b></font>|{else}<a href='javascript:changePage("{$catid}", {$nav_item.from}, {$maxfotos}, {$order}, {$edit})'>{$nav_item.num}</a>|{/if}
{/foreach}&nbsp;
			{if $next_offset < $cant_fotos}
				<a href='javascript:changePage("{$catid}", {$next_offset}, {$maxfotos}, {$order}, {$edit})'>Siguiente »</a></font></center>
			{else}
				Siguiente »</font></center>
			{/if}
{/capture}
{capture name=navtitle}
			<table width='100%' cellpadding='0' summary=''>
				<tr>
					<td align='left'>
						<font class='xx-normal'>:: <b>{$linked_path} ({$cant_fotos})</b> ::</font>
					</td>
					<td align='right'>
						{if $user_level == 100}
							{if $edit == 0}
							<font class='xx-negrita'><a href='javascript:changePage("{$catid}", {math equation="x + y" x=$prev_offset y=$maxfotos}, {$maxfotos}, {$order}, 1)'>[editar]</a></font>
							{else}
							<font class='xx-negrita'><a href='javascript:changePage("{$catid}", {math equation="x + y" x=$prev_offset y=$maxfotos}, {$maxfotos}, {$order}, 0)'>[cancelar cambios]</a><a href='javascript:changePage("{$catid}", {math equation="x + y" x=$prev_offset y=$maxfotos}, {$maxfotos}, {$order}, 2)'>[aplicar cambios]</a></font>
							{/if}
						{/if}
					</td>
				</tr>
			</table>
{/capture}
{literal}
<!--
function changeCat(ncatid)
{
	document.form_indice.catid.value = ncatid;
	document.form_indice.submit();
}
function changePage(ncatid, noffset, nmaxfotos, norder, nedit)
{
	document.form_indice.catid.value = ncatid;
	document.form_indice.offset.value = noffset;
	document.form_indice.maxfotos.value = nmaxfotos;
	document.form_indice.order.value = norder;
	document.form_indice.edit.value = nedit;
	document.form_indice.submit();
}
//-->
{/literal}
</script>
<font class='titulo'>
{$title}
</font>
<form method=POST action='index.php' name=form_indice>
<input type=hidden name=catid value="">
<input type=hidden name=page value="index.php">
<input type=hidden name=offset value="0">
<input type=hidden name=edit value="0">
<br>
<table width='100%' cellpadding='0' cellspacing='0' summary=''>
	<tr>
		<td>
			<font class='xx-normal'>ordenar por :</font>
			<font class='xx-normal'>
				<select size='1' name=order onChange="javascript:changeCat('{$catid}')">
					{html_options options=$order_options selected=$order}
				</select>
			</font>
			<font class='xx-normal'>cantidad por página :</font>
			<font class='xx-normal'>
				<select size='1' name=maxfotos onChange="javascript:changeCat('{$catid}')">
					{html_options options=$maxfotos_options selected=$maxfotos}
				</select>
			</font>
		</td>
	</tr>
</table>
<br>
<center>
<table class='gris1' width='100%' cellpadding='5' cellspacing='0' summary=''>
	<tr>
		<td>
			<font class='xx-normal'>:: <b>{$title_cat}</b> ::</font>
			<hr noshade size='1' color='#666666'>
			<table width='100%' cellpadding='0' cellspacing='0' summary=''>
				<tr>
				{if $cant_cat > 0}
					<td width='50%' valign='top'>
					{foreach from=$cat_items key=cat_file item=cant_cat name=catloop}
						<img src='images/folder-c.gif' alt='{$cat_file}'>&nbsp;<a href="javascript:changeCat('{$catid}/{$cat_file}')">{$cat_file} ({$cant_cat})</a><br>
						{if $smarty.foreach.catloop.iteration == $porcol}
					</td>
					<td width='50%' valign='top'>
						{/if}
					{/foreach}
					</td>
				{else}
				<font class='xx-normal'>No hay subcategorías</font>
				{/if}
				</tr>
			</table>
		</td>
	</tr>
</table>

<br>
<table class='gris1' width='100%' cellpadding='5' cellspacing='0' summary=''>
{if $perm_error != "0"}
	<tr>
		<td width='100%' align='center' colspan=2><font face='verdana' size='1' color='#FF0000'>El directorio de esta categoría no tiene permisos suficientes para editar</font></td>
	</tr>
{/if}
	<tr>
		<td>
			{if $cant_fotos > 0}
			{$smarty.capture.navbar}
			<hr noshade size='1' color='#666666'>
			{$smarty.capture.navtitle}
			<hr noshade size='1' color='#666666'>
			<table width='100%' cellpadding='0' cellspacing='5' summary=''>
				<tr>
					{foreach from=$foto_items key=foto_id item=foto_item name=fotoloop}
					<td width='33%' valign='top' align='center'>
						<table width='100%' class='blanco1' summary=''>
							<tr>
								<td valign='top'>
									<center>
									<table width='200' height='200' cellpadding='0' cellspacing='0' summary=''>
									    <tr>
										<td valign='middle' align='center'>
											{if $max_size <= 0 || $ismovie}
											<a href='{$foto_id}' target='_blank'><img src='getimage.php?image={$foto_id}&amp;ancho=200&amp;alto=200&amp;color=ffffff' border='0' alt='{$foto_id}'></a>
											{else}
											<a href='getsizedimage.php?image={$foto_id}&amp;ancho={$foto_item.limited_size.width}&amp;alto={$foto_item.limited_size.height}&amp;color=ffffff' target='_blank'><img src='getimage.php?image={$foto_id}&amp;ancho=200&amp;alto=200&amp;color=ffffff' border='0' alt='{$foto_id}'></a>
											{/if}
										</td>
									    </tr>
									</table>
									</center>
									<hr noshade color='#666666' size='1'>
									<table cellpadding='0' cellspacing='0' summary=''>
									    <tr>
										{foreach from=$foto_item.selectable_size key=selsize_id item=selsize_item name=selsizeloop}
										<td valign='middle' align='center'>
										<a href='getsizedimage.php?image={$foto_id}&amp;ancho={$selsize_item.width}&amp;alto={$selsize_item.height}&amp;color=ffffff' target='_blank'><img border='0' src='images/size_{$smarty.foreach.selsizeloop.iteration}.gif' alt='{$selsize_id}'></a>&nbsp;
										</td>
										{/foreach}
										</td>
									</table>
									{if $foto_item.sel_qty > 0}
									{/if}
									<font class='xx-negrita'>
									{$foto_item.date}
									{if $edit != 1}
										{if $foto_item.desc != ""}
										 - {$foto_item.desc}
										{/if}
									{else}
										<br>
										<table cellpadding='0' cellspacing='0' summary=''>
										    <tr>
												<td valign='middle' align='center'><font class='xx-normal'>Desc:&nbsp;</font></td>
												<td><input class='text' type='text' name='desc_{$foto_item.file_name}' size='40' value='{$foto_item.desc}'></td>
											</tr>
										</table>
									{/if}
									</font>
									<font class='xx-normal'>({$foto_item.reso})</font><br>
								</td>
							</tr>
						</table>
					</td>
					{if $smarty.foreach.fotoloop.iteration != $maxfotos && ( $smarty.foreach.fotoloop.iteration % $maxx == 0 ) }
				</tr>
				<tr>
					{/if}
					{/foreach}
				</tr>
			</table>
			<hr noshade size='1' color='#666666'>
			{$smarty.capture.navtitle}
			<hr noshade size='1' color='#666666'>
			{$smarty.capture.navbar}
			{else}
			{$smarty.capture.navtitle}
			<hr noshade size='1' color='#666666'>
			<font class='xx-normal'>No hay imágenes</font>
			{/if}

		</td>
	</tr>
</table>
</form>
</center>
