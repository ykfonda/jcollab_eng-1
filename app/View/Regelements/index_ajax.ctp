<br/>
<div class="col-lg-4">
    <div class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo $this->Html->url(['controller'=>'avances','action'=>'index']) ?>">
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
<div class="col-lg-12">
	<div class="table-responsive" style="min-height: auto;">
		<table class="table table-striped table-bordered  table-hover" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th nowrap="">Référence</th>
					<th nowrap="">Date de délivrance</th>
					<th nowrap="">Date échéance</th>
					<th nowrap="">Bon de commande</th>
					<th nowrap="">Bon de récéption</th>
					<th nowrap="">Mode paiment</th>
					<th nowrap="">Montant payé</th>
				</tr>
			</thead>
			<tbody>
				<?php $total_montant = 0; ?>
				<?php foreach ($taches as $tache): ?>
				<?php $total_montant = $total_montant + $tache['Avance']['montant']; ?>
				<tr>
					<td nowrap=""><?php echo h($tache['Avance']['reference']); ?></td>
					<td nowrap=""><?php echo h($tache['Avance']['date']); ?></td>
					<td nowrap=""><?php echo h($tache['Avance']['date_echeance']); ?></td>
					<td nowrap="">
						<a target="_blank" href="<?php echo $this->Html->url(['controller'=>'boncommandes','action' => 'view', $tache['Boncommande']['id']]) ?>"><?php echo h($tache['Boncommande']['reference']); ?></a>
					</td>
					<td nowrap="">
						<a target="_blank" href="<?php echo $this->Html->url(['controller'=>'bonreceptions','action' => 'view', $tache['Bonreception']['id']]) ?>"><?php echo h($tache['Bonreception']['reference']); ?></a>
					</td>
					<td nowrap=""><?php echo $this->App->getModePaiment($tache['Avance']['mode']); ?></td>
					<td nowrap="" class="text-right"><?php echo number_format($tache['Avance']['montant'], 2, ',', ' '); ?></td>
				</tr>
				<?php endforeach; ?>
				<tr class="total">
	                <td nowrap=""></td>
	                <td nowrap=""></td>
	                <td nowrap=""></td>
	                <td nowrap=""></td>
	                <td nowrap=""></td>
	                <td nowrap=""></td>
	                <td nowrap="" class="text-right"><strong><?php echo number_format($total_montant, 2, ',', ' ') ?></strong></td>
	            </tr>
			</tbody>
		</table>
	</div>
</div>