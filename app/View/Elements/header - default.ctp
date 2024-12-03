<?php
//$compact = [];
$nomDoc = isset($etatformulaire['Etatformulaire']['libelle'])? $etatformulaire['Etatformulaire']['libelle'] : '';
$code = isset($etatformulaire['Document']['code'])? $etatformulaire['Document']['code'] : '';
$version = isset($etatformulaire['Document']['Defaultversion']['numversion'])? $this->App->getVersion($etatformulaire['Document']['Defaultversion']['numversion'] ,$ParametreSte['Doc_typeVersion']) : '';
$date = isset($etatformulaire['Document']['Defaultversion']['date_diffusion'])? $etatformulaire['Document']['Defaultversion']['date_diffusion'] : null;
$logo = $ParametreSte['Etat_logo'];
//debug($etatformulaire);die;
?>

<!-- <div style="float:left;width:100px;"><img src="<?php echo WWW_ROOT.$logo ?>" width="100%"/></div>
<div style="float:left;width:358px;padding-top:10px">
	<h2 style="text-align:center;">
		<?php echo $nomDoc ?>
	</h2>
	<div style="text-align:right;">
		
	</div>
</div>
<div style="float:left;width:200px;padding-top:10px">
<?php echo $code ?> - <?php echo $version ?>
		<?php if(!empty($date)) echo ' / '.date('d-m-Y',strtotime($date)) ?>
</div>
<div style="clear:both"></div>
<br><br> -->

<style>
	table{
		border-collapse: collapse;
	}
	table td{
		border: 1px solid #000;
	}
</style>

<table style="width: 100%; border: 1px solid #000">
	<tr>
		<td rowspan="2" style="width: 200px">
			<img src="<?php echo WWW_ROOT.$logo ?>" width="100%" height="50px"/>
		</td>
		<td rowspan="2" style="text-align: center;">
			<h2><?php echo $nomDoc ?></h2>
		</td>
		<td style="width: 180px; padding: 5px">
			Réf : <?php echo $code ?> - <?php echo $version ?>
		</td>
	</tr>
	<tr>
		<td style="padding: 5px">
			Date application : <?php if(!empty($date)) echo date('d-m-Y',strtotime($date)) ?>
		</td>
	</tr>
</table>
<br><br>