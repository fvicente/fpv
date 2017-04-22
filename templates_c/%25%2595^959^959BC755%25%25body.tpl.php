<?php /* Smarty version 2.6.9, created on 2005-08-25 13:49:30
         compiled from body.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'math', 'body.tpl', 26, false),array('function', 'html_options', 'body.tpl', 69, false),)), $this); ?>
<script language='JavaScript' type='text/javascript'>
<?php ob_start(); ?>
			<?php if ($this->_tpl_vars['prev_offset'] >= 0): ?>
			<center><font class='xx-normal'><a href='javascript:changePage("<?php echo $this->_tpl_vars['catid']; ?>
", <?php echo $this->_tpl_vars['prev_offset']; ?>
, <?php echo $this->_tpl_vars['maxfotos']; ?>
, <?php echo $this->_tpl_vars['order']; ?>
, <?php echo $this->_tpl_vars['edit']; ?>
)'>« Anterior</a>
			<?php else: ?>
			<center><font class='xx-normal'>« Anterior
			<?php endif; ?>
&nbsp;|<?php $_from = $this->_tpl_vars['nav_items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['navloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['navloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['nav_key'] => $this->_tpl_vars['nav_item']):
        $this->_foreach['navloop']['iteration']++;
?>
<?php if ($this->_tpl_vars['nav_current'] == $this->_tpl_vars['nav_key']): ?><font color='#FF0000'><b><?php echo $this->_tpl_vars['nav_item']['num']; ?>
</b></font>|<?php else: ?><a href='javascript:changePage("<?php echo $this->_tpl_vars['catid']; ?>
", <?php echo $this->_tpl_vars['nav_item']['from']; ?>
, <?php echo $this->_tpl_vars['maxfotos']; ?>
, <?php echo $this->_tpl_vars['order']; ?>
, <?php echo $this->_tpl_vars['edit']; ?>
)'><?php echo $this->_tpl_vars['nav_item']['num']; ?>
</a>|<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>&nbsp;
			<?php if ($this->_tpl_vars['next_offset'] < $this->_tpl_vars['cant_fotos']): ?>
				<a href='javascript:changePage("<?php echo $this->_tpl_vars['catid']; ?>
", <?php echo $this->_tpl_vars['next_offset']; ?>
, <?php echo $this->_tpl_vars['maxfotos']; ?>
, <?php echo $this->_tpl_vars['order']; ?>
, <?php echo $this->_tpl_vars['edit']; ?>
)'>Siguiente »</a></font></center>
			<?php else: ?>
				Siguiente »</font></center>
			<?php endif; ?>
<?php $this->_smarty_vars['capture']['navbar'] = ob_get_contents(); ob_end_clean(); ?>
<?php ob_start(); ?>
			<table width='100%' cellpadding='0' summary=''>
				<tr>
					<td align='left'>
						<font class='xx-normal'>:: <b><?php echo $this->_tpl_vars['linked_path']; ?>
 (<?php echo $this->_tpl_vars['cant_fotos']; ?>
)</b> ::</font>
					</td>
					<td align='right'>
						<?php if ($this->_tpl_vars['user_level'] == 100): ?>
							<?php if ($this->_tpl_vars['edit'] == 0): ?>
							<font class='xx-negrita'><a href='javascript:changePage("<?php echo $this->_tpl_vars['catid']; ?>
", <?php echo smarty_function_math(array('equation' => "x + y",'x' => $this->_tpl_vars['prev_offset'],'y' => $this->_tpl_vars['maxfotos']), $this);?>
, <?php echo $this->_tpl_vars['maxfotos']; ?>
, <?php echo $this->_tpl_vars['order']; ?>
, 1)'>[editar]</a></font>
							<?php else: ?>
							<font class='xx-negrita'><a href='javascript:changePage("<?php echo $this->_tpl_vars['catid']; ?>
", <?php echo smarty_function_math(array('equation' => "x + y",'x' => $this->_tpl_vars['prev_offset'],'y' => $this->_tpl_vars['maxfotos']), $this);?>
, <?php echo $this->_tpl_vars['maxfotos']; ?>
, <?php echo $this->_tpl_vars['order']; ?>
, 0)'>[cancelar cambios]</a><a href='javascript:changePage("<?php echo $this->_tpl_vars['catid']; ?>
", <?php echo smarty_function_math(array('equation' => "x + y",'x' => $this->_tpl_vars['prev_offset'],'y' => $this->_tpl_vars['maxfotos']), $this);?>
, <?php echo $this->_tpl_vars['maxfotos']; ?>
, <?php echo $this->_tpl_vars['order']; ?>
, 2)'>[aplicar cambios]</a></font>
							<?php endif; ?>
						<?php endif; ?>
					</td>
				</tr>
			</table>
<?php $this->_smarty_vars['capture']['navtitle'] = ob_get_contents(); ob_end_clean(); ?>
<?php echo '
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
'; ?>

</script>
<font class='titulo'>
<?php echo $this->_tpl_vars['title']; ?>

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
				<select size='1' name=order onChange="javascript:changeCat('<?php echo $this->_tpl_vars['catid']; ?>
')">
					<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['order_options'],'selected' => $this->_tpl_vars['order']), $this);?>

				</select>
			</font>
			<font class='xx-normal'>cantidad por página :</font>
			<font class='xx-normal'>
				<select size='1' name=maxfotos onChange="javascript:changeCat('<?php echo $this->_tpl_vars['catid']; ?>
')">
					<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['maxfotos_options'],'selected' => $this->_tpl_vars['maxfotos']), $this);?>

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
			<font class='xx-normal'>:: <b><?php echo $this->_tpl_vars['title_cat']; ?>
</b> ::</font>
			<hr noshade size='1' color='#666666'>
			<table width='100%' cellpadding='0' cellspacing='0' summary=''>
				<tr>
				<?php if ($this->_tpl_vars['cant_cat'] > 0): ?>
					<td width='50%' valign='top'>
					<?php $_from = $this->_tpl_vars['cat_items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['catloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['catloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['cat_file'] => $this->_tpl_vars['cant_cat']):
        $this->_foreach['catloop']['iteration']++;
?>
						<img src='images/folder-c.gif' alt='<?php echo $this->_tpl_vars['cat_file']; ?>
'>&nbsp;<a href="javascript:changeCat('<?php echo $this->_tpl_vars['catid']; ?>
/<?php echo $this->_tpl_vars['cat_file']; ?>
')"><?php echo $this->_tpl_vars['cat_file']; ?>
 (<?php echo $this->_tpl_vars['cant_cat']; ?>
)</a><br>
						<?php if ($this->_foreach['catloop']['iteration'] == $this->_tpl_vars['porcol']): ?>
					</td>
					<td width='50%' valign='top'>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
					</td>
				<?php else: ?>
				<font class='xx-normal'>No hay subcategorías</font>
				<?php endif; ?>
				</tr>
			</table>
		</td>
	</tr>
</table>

<br>
<table class='gris1' width='100%' cellpadding='5' cellspacing='0' summary=''>
<?php if ($this->_tpl_vars['perm_error'] != '0'): ?>
	<tr>
		<td width='100%' align='center' colspan=2><font face='verdana' size='1' color='#FF0000'>El directorio de esta categoría no tiene permisos suficientes para editar</font></td>
	</tr>
<?php endif; ?>
	<tr>
		<td>
			<?php if ($this->_tpl_vars['cant_fotos'] > 0): ?>
			<?php echo $this->_smarty_vars['capture']['navbar']; ?>

			<hr noshade size='1' color='#666666'>
			<?php echo $this->_smarty_vars['capture']['navtitle']; ?>

			<hr noshade size='1' color='#666666'>
			<table width='100%' cellpadding='0' cellspacing='5' summary=''>
				<tr>
					<?php $_from = $this->_tpl_vars['foto_items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['fotoloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fotoloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['foto_id'] => $this->_tpl_vars['foto_item']):
        $this->_foreach['fotoloop']['iteration']++;
?>
					<td width='33%' valign='top' align='center'>
						<table width='100%' class='blanco1' summary=''>
							<tr>
								<td valign='top'>
									<center>
									<table width='200' height='200' cellpadding='0' cellspacing='0' summary=''>
									    <tr>
										<td valign='middle' align='center'>
											<?php if ($this->_tpl_vars['max_size'] <= 0 || $this->_tpl_vars['ismovie']): ?>
											<a href='<?php echo $this->_tpl_vars['foto_id']; ?>
' target='_blank'><img src='getimage.php?image=<?php echo $this->_tpl_vars['foto_id']; ?>
&amp;ancho=200&amp;alto=200&amp;color=ffffff' border='0' alt='<?php echo $this->_tpl_vars['foto_id']; ?>
'></a>
											<?php else: ?>
											<a href='getsizedimage.php?image=<?php echo $this->_tpl_vars['foto_id']; ?>
&amp;ancho=<?php echo $this->_tpl_vars['foto_item']['limited_size']['width']; ?>
&amp;alto=<?php echo $this->_tpl_vars['foto_item']['limited_size']['height']; ?>
&amp;color=ffffff' target='_blank'><img src='getimage.php?image=<?php echo $this->_tpl_vars['foto_id']; ?>
&amp;ancho=200&amp;alto=200&amp;color=ffffff' border='0' alt='<?php echo $this->_tpl_vars['foto_id']; ?>
'></a>
											<?php endif; ?>
										</td>
									    </tr>
									</table>
									</center>
									<hr noshade color='#666666' size='1'>
									<table cellpadding='0' cellspacing='0' summary=''>
									    <tr>
										<?php $_from = $this->_tpl_vars['foto_item']['selectable_size']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['selsizeloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['selsizeloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['selsize_id'] => $this->_tpl_vars['selsize_item']):
        $this->_foreach['selsizeloop']['iteration']++;
?>
										<td valign='middle' align='center'>
										<a href='getsizedimage.php?image=<?php echo $this->_tpl_vars['foto_id']; ?>
&amp;ancho=<?php echo $this->_tpl_vars['selsize_item']['width']; ?>
&amp;alto=<?php echo $this->_tpl_vars['selsize_item']['height']; ?>
&amp;color=ffffff' target='_blank'><img border='0' src='images/size_<?php echo $this->_foreach['selsizeloop']['iteration']; ?>
.gif' alt='<?php echo $this->_tpl_vars['selsize_id']; ?>
'></a>&nbsp;
										</td>
										<?php endforeach; endif; unset($_from); ?>
										</td>
									</table>
									<?php if ($this->_tpl_vars['foto_item']['sel_qty'] > 0): ?>
									<?php endif; ?>
									<font class='xx-negrita'>
									<?php echo $this->_tpl_vars['foto_item']['date']; ?>

									<?php if ($this->_tpl_vars['edit'] != 1): ?>
										<?php if ($this->_tpl_vars['foto_item']['desc'] != ""): ?>
										 - <?php echo $this->_tpl_vars['foto_item']['desc']; ?>

										<?php endif; ?>
									<?php else: ?>
										<br>
										<table cellpadding='0' cellspacing='0' summary=''>
										    <tr>
												<td valign='middle' align='center'><font class='xx-normal'>Desc:&nbsp;</font></td>
												<td><input class='text' type='text' name='desc_<?php echo $this->_tpl_vars['foto_item']['file_name']; ?>
' size='40' value='<?php echo $this->_tpl_vars['foto_item']['desc']; ?>
'></td>
											</tr>
										</table>
									<?php endif; ?>
									</font>
									<font class='xx-normal'>(<?php echo $this->_tpl_vars['foto_item']['reso']; ?>
)</font><br>
								</td>
							</tr>
						</table>
					</td>
					<?php if ($this->_foreach['fotoloop']['iteration'] != $this->_tpl_vars['maxfotos'] && ( $this->_foreach['fotoloop']['iteration'] % $this->_tpl_vars['maxx'] == 0 )): ?>
				</tr>
				<tr>
					<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
				</tr>
			</table>
			<hr noshade size='1' color='#666666'>
			<?php echo $this->_smarty_vars['capture']['navtitle']; ?>

			<hr noshade size='1' color='#666666'>
			<?php echo $this->_smarty_vars['capture']['navbar']; ?>

			<?php else: ?>
			<?php echo $this->_smarty_vars['capture']['navtitle']; ?>

			<hr noshade size='1' color='#666666'>
			<font class='xx-normal'>No hay imágenes</font>
			<?php endif; ?>

		</td>
	</tr>
</table>
</form>
</center>