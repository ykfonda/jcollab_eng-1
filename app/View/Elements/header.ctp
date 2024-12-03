<?php if ( isset( $societe['Societe']['show_entete'] ) AND $societe['Societe']['show_entete'] == 1 ): ?> 
	<header>
		<table style="width: 100%;height: 150px;margin-top: -50px;">
			<tr>
				<?php $logo = ( isset( $societe['Societe']['avatar'] ) ) ? $societe['Societe']['avatar'] : ''; ?>
				<td style="text-align: center;">
					<?php if ( isset( $societe['Societe']['show_logo'] ) AND $societe['Societe']['show_logo'] == 1 ): ?> 
						<h1 style="font-size: 50px;"><?php echo strtoupper( $societe['Societe']['designation'] ) ?></h1>
					<?php else: ?>
						<?php if ( !file_exists( WWW_ROOT.$logo ) ): ?>
							<h1 style="font-size: 50px;"><?php echo strtoupper( $societe['Societe']['designation'] ) ?></h1>
						<?php else: ?>
							<img src="<?php echo WWW_ROOT.$logo ?>" style="height: 150px"/>
						<?php endif ?>
					<?php endif ?>
				</td>
			</tr>
		</table>
	</header>
<?php else: ?>
	<header style="width: 100%;height: 150px;margin-top: -40px;"></header>
<?php endif ?>
