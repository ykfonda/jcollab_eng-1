<?php if ( isset( $societe['Societe']['show_enbas'] ) AND $societe['Societe']['show_enbas'] == 1 ): ?> 
	<footer>
	    <strong><?php echo strtoupper($societe['Societe']['designation']) ?></strong><br/>
	    <strong><?php echo strtoupper($societe['Societe']['adresse']) ?></strong><br/>
	    <strong> ICE : </strong><?php echo $societe['Societe']['ice'] ?>
	    <strong>  - RC : </strong><?php echo $societe['Societe']['registrecommerce'] ?>
	    <strong> - Patente : </strong><?php echo $societe['Societe']['patent'] ?>
	    <strong> - IF : </strong><?php echo $societe['Societe']['idfiscale'] ?>
	</footer>
<?php else: ?>
	<footer style="border:none;"></footer>
<?php endif ?>