<br/>
<div class="row">
	<div class="col-lg-4">
	    <div class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo $this->Html->url(['controller'=>'depences','action'=>'index']) ?>">
	        <div class="visual">
	            <i class="fa fa-dollar"></i>
	        </div>
	        <div class="details">
	            <div class="number">
	                <span data-counter="counterup" data-value="<?php echo $chiffre_affaire_valide ?>"><?php echo number_format($chiffre_affaire_valide, 2, ',', ' ') ?> Dh</span>
	            </div>
	            <div class="desc"> Total des dépences  </div>
	        </div>
	    </div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="table-scrollable" style="min-height: auto;">
			<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th nowrap="">Réf. dépence</th>
						<th nowrap="">Date</th>
						<th nowrap="">Date échéance</th>
						<th nowrap="">Catégorie</th>
						<th nowrap="">Bon de commande</th>
						<th nowrap="">Bon de récéption</th>
						<th nowrap="">Mode paiment</th>
						<th nowrap="">Montant payé</th>
						<th nowrap="">Créé par</th>
						<th nowrap="">Date création</th>
						<th class="actions" nowrap="">
					</tr>
				</thead>
				<tbody>
					<?php foreach ($taches as $tache): ?>
					<tr>
						<td nowrap=""><?php echo h($tache['Depence']['reference']); ?></td>
						<td nowrap=""><?php echo h($tache['Depence']['date']); ?></td>
						<td nowrap=""><?php echo h($tache['Depence']['date_echeance']); ?></td>
						<td nowrap=""><?php echo h($tache['Categoriedepence']['libelle']); ?></td>
						<td nowrap="">
							<a target="_blank" href="<?php echo $this->Html->url(['controller'=>'boncommandes','action' => 'view', $tache['Boncommande']['id']]) ?>"><?php echo h($tache['Boncommande']['reference']); ?></a>
						</td>
						<td nowrap="">
							<a target="_blank" href="<?php echo $this->Html->url(['controller'=>'bonreceptions','action' => 'view', $tache['Bonreception']['id']]) ?>"><?php echo h($tache['Bonreception']['reference']); ?></a>
						</td>
						<td nowrap=""><?php echo $this->App->getModePaiment($tache['Depence']['mode']); ?></td>
						<td nowrap="" class="text-right"><?php echo number_format($tache['Depence']['montant'], 2, ',', ' '); ?></td>
						<td nowrap=""><?php echo h($tache['Creator']['nom']); ?> <?php echo h($tache['Creator']['prenom']); ?></td>
						<td nowrap=""><?php echo h($tache['Depence']['date_c']); ?></td>
						<td class="actions">
							<?php if ($globalPermission['Permission']['m1'] AND $tache['Categoriedepence']['id'] != 1 ): ?>
								<a href="<?php echo $this->Html->url(['action' => 'edit', $tache['Depence']['id']]) ?>" class="edit"><i class="fa fa-edit"></i> Modifier</a>
							<?php endif ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>