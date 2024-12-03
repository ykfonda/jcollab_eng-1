<center>
	<?php $logo = ( isset( $societe['Societe']['logo'] ) ) ? $societe['Societe']['logo'] : ''; ?>
	<?php if ( file_exists( WWW_ROOT.$logo ) AND $societe['Societe']['show_logo'] == 1 ): ?>
		<img src="<?php echo WWW_ROOT.$logo ?>" style="width: 200px"/>
	<?php endif ?><br/>
</center>