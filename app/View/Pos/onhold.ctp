<div class="modal-header">
	<h4 class="modal-title">
		Liste d'attente (<?php echo count($holding) ?>)
	</h4>
</div>
<div class="modal-body ">
	<div class="row">
		<?php if ( empty( $holding ) ): ?>
			<div class="col-md-12">
				<div class="alert alert-danger text-center p-2" style="font-weight: bold;font-size: 20px;">Liste des articles est vide !</div>
			</div>
		<?php else: ?>
			<div class="col-md-6" style="border:1px solid #e5e5e5;">
				<div class="table-responsive" style="min-height: auto;max-height: 450px;overflow-y: scroll;">
					<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th class="actions"></th>
								<th nowrap="">Référence</th>
								<th nowrap="">Date</th>
								<th nowrap="">Type</th>
								<th nowrap="">Remise(%)</th>
								<th nowrap="">Date création</th>
								<th class="actions"></th>
							</tr>
						</thead>
						<tbody>
							<!-- Type De vente -->
							<input type="hidden" id="type_cmd_value" value="<?php print_r($sales["Salepoint"]["type_vente"]) ?>" />
							<?php foreach ($holding as $dossier): ?>
								<tr>
									<td nowrap=""><a class="holdoff btn btn-danger btn-sm btn-block" href="<?php echo $this->Html->url(['action'=>'holdoff',$dossier['Attente']['id']]) ?>"><i class="fa fa-reply"></i> Continuer</a></td>
									<td nowrap=""><a class="getdetail" href="<?php echo $this->Html->url(['action'=>'holdingdetail',$dossier['Attente']['id']]) ?>"><?php echo h($dossier['Attente']['reference']); ?></a></td>
									<td nowrap=""><?php echo h($dossier['Attente']['date']); ?></td>
									<td class="type_cmd"></td>
									<td nowrap="" class="text-right"><?php echo number_format($dossier['Attente']['remise'], 2, ',', ' '); ?>%</td>
									<td nowrap=""><?php echo h($dossier['Attente']['date_c']); ?></td>
									<td nowrap="" class="actions">
										<a class="getdetail btn btn-primary btn-sm btn-block" href="<?php echo $this->Html->url(['action'=>'holdingdetail',$dossier['Attente']['id']]) ?>"><i class="fa fa-eye"></i> Voir détails</a>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-6" style="border:1px solid #e5e5e5;">
				<div id="showdetail"></div>
			</div>
		<?php endif ?>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn default" data-dismiss="modal">Fermer</button>
</div>

<script>
	var cols = document.querySelectorAll(".type_cmd");
	cols.forEach(col => {
		switch (Number(document.getElementById("type_cmd_value").value)) {
			case -1:
				col.innerHTML = "Direct"
				break;
			case 1:
				col.innerHTML = "Ecommerce"
				break;
		
			default:
				col.innerHTML = "Commande Client"
				break;
		}
	});
</script>