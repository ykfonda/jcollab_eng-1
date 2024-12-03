<div class="modal-header">
	<h4 class="modal-title">
		Liste des commandes client (<?php echo count( $commandes ) ?>)
	</h4>
</div>
<div class="modal-body ">
	<div class="row">
		<?php if ( empty( $commandes ) ): ?>
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
								<th nowrap="">Client</th>
								<th nowrap="">Remise(%)</th>
								<th nowrap="">Net à payer</th>
								<th class="actions"></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($commandes as $dossier): ?>
								<tr>
									<td nowrap=""><a class="traitercommande btn btn-danger btn-sm btn-block" href="<?php echo $this->Html->url(['action'=>'traitercommande',$dossier['Commande']['id']]) ?>"><i class="fa fa-reply"></i> Traiter</a></td>
									<td nowrap=""><a class="getdetail" href="<?php echo $this->Html->url(['action'=>'commandedetails',$dossier['Commande']['id']]) ?>"><?php echo h($dossier['Commande']['reference']); ?></a></td>
									<td nowrap=""><?php echo h($dossier['Commande']['date']); ?></td>
									<td nowrap=""><?php echo h($dossier['Client']['designation']); ?></td>
									<td nowrap="" class="text-right"><?php echo number_format($dossier['Commande']['remise'], 2, ',', ' '); ?>%</td>
									<td nowrap="" class="text-right"><?php echo number_format($dossier['Commande']['total_apres_reduction'], 2, ',', ' '); ?></td>
									<td nowrap="" class="actions">
										<a class="getdetail btn btn-primary btn-sm btn-block" href="<?php echo $this->Html->url(['action'=>'commandedetails',$dossier['Commande']['id']]) ?>"><i class="fa fa-eye"></i> Détails</a>
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