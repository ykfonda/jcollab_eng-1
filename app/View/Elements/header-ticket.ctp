<style>
.same-size{
	font-size:10px !important;
}
</style>

<div id="header" class="same-size" >
	<?php $logo = ( isset( $societe['Societe']['avatar'] ) ) ? $societe['Societe']['avatar'] : ''; ?>
	<?php if ( isset( $societe['Societe']['show_logo'] ) AND $societe['Societe']['show_logo'] == 1 ): ?> 
		<?php echo strtoupper( $societe['Societe']['designation'] ) ?>
	<?php else: ?>
		<?php if ( !file_exists( WWW_ROOT.$logo ) ): ?>
			<p class="same-size"><?php echo strtoupper( $societe['Societe']['designation'] ) ?></h1>
		<?php else: ?>
			<img src="<?php echo $this->Html->url('../'.$logo) ?>" style="height: 120px;"/>
		<?php endif ?>
	<?php endif ?>
</div>
<br />

<div class="titles-ticket"><?php echo $societe['Societe']['designation'] ?></div>


	<?php if ( isset( $store_data['Store']['libelle'] ) AND !empty( $store_data['Store']['libelle'] ) ): ?>
	<div class="titles-ticket"><?php echo $store_data['Store']['libelle'] ?></div>
	
<div class="titles-ticket">
	<?php endif ?>
	<b>Adress : </b><?php echo $store_data['Store']['adresse'] ?>
<br />
	<b>Phone : </b><?php echo $store_data['Store']['tel'] ?> <br />
	<b>TRN : </b><?php echo $societe['Societe']['idfiscale'] ?>
	<!-- <b>IF : </b><?php // echo $societe['Societe']['idfiscale'] ?> 
	<b>ICE : </b><?php // echo $societe['Societe']['ice'] ?>
	<b><br />TP : </b><?php //echo $store_data['Store']['numero_tp'] ?>-->
</div>