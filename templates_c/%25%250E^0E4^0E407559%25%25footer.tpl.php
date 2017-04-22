<?php /* Smarty version 2.6.9, created on 2005-08-25 13:36:46
         compiled from footer.tpl */ ?>
			<hr noshade color='#666666' size='1'>
			<table width='100%' cellpadding='0' cellspacing='0' summary=''>
				<tr>
					<td valign='top' align='left'>
						<?php if ($this->_tpl_vars['user'] != ""): ?>
						<font class='xx-normal'>Usuário: <?php echo $this->_tpl_vars['user']; ?>
</font><br>
						<?php endif; ?>
						<?php if ($this->_tpl_vars['counter'] != ""): ?>
						<font class='xx-normal'>Visitante número: <?php echo $this->_tpl_vars['counter']; ?>
</font>
						<?php endif; ?>
					</td>
					<td valign='top' align='right'>
						<font class='xx-normal'><?php echo $this->_tpl_vars['copyright']; ?>
<br>
						Webmaster: <a href='mailto:<?php echo $this->_tpl_vars['email']; ?>
'><?php echo $this->_tpl_vars['email']; ?>
</a></font>
					</td>
				</tr>
			</table>